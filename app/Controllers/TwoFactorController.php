<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Domain\Models\TrustedDeviceModel;
use App\Domain\Models\TwoFactorAuthModel;
use App\Domain\Models\UserModel;
use App\Helpers\FlashMessage;
use App\Helpers\SessionManager;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use RobThree\Auth\Providers\Qr\BaconQrCodeProvider;
use RobThree\Auth\TwoFactorAuth;

class TwoFactorController extends BaseController
{
    private const TOTP_ISSUER = 'LivePlay';

    public function __construct(
        ContainerInterface $container,
        private TwoFactorAuthModel $twoFactorModel,
        private UserModel $userModel,
        private TrustedDeviceModel $trustedDeviceModel
    ) {
        parent::__construct($container);
    }

    public function showSetup(Request $request, Response $response): Response
    {
        $user = SessionManager::get('user');
        if (!$user) {
            return $this->redirect($request, $response, 'auth.login');
        }

        $userId = (int) $user['id'];
        $userEmail = (string) $user['email'];

        if ($this->twoFactorModel->isEnabled($userId)) {
            FlashMessage::error('2FA is already enabled.');
            return $this->redirect($request, $response, 'user.dashboard');
        }

        $twoFA = $this->createTwoFactorAuth();
        $secret = $twoFA->createSecret();

        SessionManager::set('2fa_setup_secret', $secret);

        return $this->render($response, 'auth/2fa-setup.php', [
            'title' => 'Enable 2FA',
            'qrCodeDataUri' => $twoFA->getQRCodeImageAsDataUri($userEmail, $secret, 250),
            'secret' => $secret,
        ]);
    }

    public function verifyAndEnable(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody() ?? [];
        $user = SessionManager::get('user');

        if (!$user) {
            return $this->redirect($request, $response, 'auth.login');
        }

        $userId = (int) $user['id'];
        $userEmail = (string) $user['email'];
        $code = $this->normalizeCode($data['code'] ?? '');

        $setupSecret = SessionManager::get('2fa_setup_secret');
        if (!$setupSecret) {
            FlashMessage::error('2FA setup expired. Please start again.');
            return $this->redirect($request, $response, '2fa.setup');
        }

        $twoFA = $this->createTwoFactorAuth();

        if (!$twoFA->verifyCode($setupSecret, $code)) {
            return $this->render($response, 'auth/2fa-setup.php', [
                'title' => 'Enable 2FA',
                'error' => 'Invalid verification code. Please try again.',
                'qrCodeDataUri' => $twoFA->getQRCodeImageAsDataUri($userEmail, $setupSecret, 250),
                'secret' => $setupSecret,
            ]);
        }

        $existing = $this->twoFactorModel->findByUserId($userId);
        if (!$existing) {
            $this->twoFactorModel->create($userId, $setupSecret);
        } else {
            $this->twoFactorModel->updateSecret($userId, $setupSecret);
        }

        $this->twoFactorModel->enable($userId);

        SessionManager::remove('2fa_setup_secret');
        SessionManager::set('2fa_verified', true);
        SessionManager::set('requires_2fa', true);

        FlashMessage::success('2FA enabled successfully!');

        return $this->redirect($request, $response, 'user.dashboard');
    }

    public function showVerify(Request $request, Response $response): Response
    {
        $user = SessionManager::get('user');
        if (!$user) {
            return $this->redirect($request, $response, 'auth.login');
        }

        return $this->render($response, 'auth/2fa-verify.php', [
            'title' => 'Verify Code',
        ]);
    }

    public function verify(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody() ?? [];
        $user = SessionManager::get('user');

        if (!$user) {
            return $this->redirect($request, $response, 'auth.login');
        }

        $userId = (int) $user['id'];
        $code = $this->normalizeCode($data['code'] ?? '');

        $secret = $this->twoFactorModel->getSecret($userId);
        if (!$secret || !$this->twoFactorModel->isEnabled($userId)) {
            FlashMessage::error('Two-factor authentication is not configured for this account.');
            return $this->redirect($request, $response, 'auth.login');
        }

        $twoFA = $this->createTwoFactorAuth();

        if (!$twoFA->verifyCode($secret, $code)) {
            $attempts = (int) (SessionManager::get('2fa_attempts') ?? 0) + 1;
            SessionManager::set('2fa_attempts', $attempts);

            if ($attempts >= 5) {
                SessionManager::destroy();
                FlashMessage::error('Too many failed attempts. Please log in again.');
                return $this->redirect($request, $response, 'auth.login');
            }

            FlashMessage::error('Invalid verification code.');
            return $this->render($response, 'auth/2fa-verify.php', [
                'title' => 'Verify Code',
            ]);
        }

        SessionManager::set('2fa_verified', true);
        SessionManager::set('2fa_attempts', 0);
        session_regenerate_id(true);

        $routeName = SessionManager::get('post_login_route');
        $routeArgs = SessionManager::get('post_login_route_args', []);
        $destination = SessionManager::get('post_2fa_route', 'user.dashboard');
        SessionManager::remove('post_login_route');
        SessionManager::remove('post_login_route_args');
        SessionManager::remove('post_2fa_route');

        FlashMessage::success('Verification successful.');

        if (is_string($routeName) && $routeName !== '') {
            return $this->redirect($request, $response, $routeName, is_array($routeArgs) ? $routeArgs : []);
        }

        return $this->redirect($request, $response, $destination);
    }

    public function showDisable(Request $request, Response $response): Response
    {
        $user = SessionManager::get('user');
        if (!$user) {
            return $this->redirect($request, $response, 'auth.login');
        }

        return $this->render($response, 'auth/2fa-disable.php', [
            'title' => 'Disable 2FA',
        ]);
    }

    public function disable(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody() ?? [];
        $password = $data['password'] ?? null;

        if (!$password) {
            FlashMessage::error('Password is required.');
            return $this->render($response, 'auth/2fa-disable.php', [
                'title' => 'Disable 2FA',
            ]);
        }

        $sessionUser = SessionManager::get('user');
        if (!$sessionUser || empty($sessionUser['email'])) {
            FlashMessage::error('Session expired. Please log in again.');
            return $this->redirect($request, $response, 'auth.login');
        }

        $user = $this->userModel->findByEmail($sessionUser['email']);
        if (
            !$user
            || empty($user['password_hash'])
            || !password_verify((string) $password, $user['password_hash'])
        ) {
            FlashMessage::error('Invalid credentials.');
            return $this->render($response, 'auth/2fa-disable.php', [
                'title' => 'Disable 2FA',
            ]);
        }

        $userId = (int) $sessionUser['id'];
        $this->twoFactorModel->disable($userId);
        $this->trustedDeviceModel->revokeAll($userId);

        SessionManager::set('2fa_verified', true);
        SessionManager::set('requires_2fa', false);

        $this->clearTrustedDeviceCookie();

        FlashMessage::success('2FA disabled successfully.');

        return $this->redirect($request, $response, 'user.dashboard');
    }

    private function createTwoFactorAuth(): TwoFactorAuth
    {
        $qrProvider = new BaconQrCodeProvider(
            250,
            '#ffffff',
            '#000000',
            'svg'
        );

        return new TwoFactorAuth($qrProvider, self::TOTP_ISSUER);
    }

    private function normalizeCode(mixed $code): string
    {
        $digits = preg_replace('/\D/', '', (string) $code);

        return strlen($digits) === 6 ? $digits : '';
    }

    private function trustDevice(Request $request, int $userId): void
    {
        $deviceToken = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+30 days'));

        $this->trustedDeviceModel->create($userId, $deviceToken, [
            'name' => $this->getDeviceName($request),
            'user_agent' => $request->getHeaderLine('User-Agent'),
            'ip_address' => $this->getClientIp($request),
            'expires_at' => $expiresAt,
        ]);

        setcookie('trusted_device', $deviceToken, [
            'expires' => time() + (30 * 24 * 60 * 60),
            'path' => '/',
            'httponly' => true,
            'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
            'samesite' => 'Strict',
        ]);

        $this->trustedDeviceModel->updateLastUsed($deviceToken);
    }

    private function clearTrustedDeviceCookie(): void
    {
        setcookie('trusted_device', '', [
            'expires' => time() - 3600,
            'path' => '/',
            'httponly' => true,
            'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
            'samesite' => 'Strict',
        ]);
    }

    private function getDeviceName(Request $request): string
    {
        $userAgent = $request->getHeaderLine('User-Agent');

        if (stripos($userAgent, 'Windows') !== false) {
            return 'Windows PC';
        }
        if (stripos($userAgent, 'Mac') !== false) {
            return 'Mac';
        }
        if (stripos($userAgent, 'iPhone') !== false) {
            return 'iPhone';
        }
        if (stripos($userAgent, 'Android') !== false) {
            return 'Android';
        }
        if (stripos($userAgent, 'Linux') !== false) {
            return 'Linux PC';
        }

        return 'Unknown Device';
    }

    private function getClientIp(Request $request): string
    {
        $serverParams = $request->getServerParams();

        if (!empty($serverParams['HTTP_X_FORWARDED_FOR'])) {
            $ipList = explode(',', $serverParams['HTTP_X_FORWARDED_FOR']);
            return trim($ipList[0]);
        }

        return $serverParams['REMOTE_ADDR'] ?? '0.0.0.0';
    }
}
