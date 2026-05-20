<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Domain\Models\TrustedDeviceModel;
use App\Domain\Models\TwoFactorAuthModel;
use App\Domain\Models\UserModel;
use App\Helpers\FlashMessage;
use App\Helpers\SessionManager;
use RobThree\Auth\TwoFactorAuth;
use RobThree\Auth\Providers\Qr\BaconQrCodeProvider;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class TwoFactorController extends BaseController
{
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

        $userId = $user['id'];
        $userEmail = $user['email'];

        // already enabled
        if ($this->twoFactorModel->isEnabled($userId)) {

            FlashMessage::error('2FA already enabled');

            return $this->redirect(
                $request,
                $response,
                'user.dashboard'
            );
        }

        // create QR provider
        $qrProvider = new BaconQrCodeProvider(
            500,
            '#ffffff',
            '#000000',
            'svg'
        );

        // create TFA instance
        $twoFA = new TwoFactorAuth(
            $qrProvider,
            'BrewFinder'
        );

        // generate secret
        $secret = $twoFA->createSecret();

        // temporary session storage
        SessionManager::set(
            '2fa_setup_secret',
            $secret
        );

        // generate QR code
        $qrCodeDataUri = $twoFA->getQRCodeImageAsDataUri(
            $userEmail,
            $secret
        );

        $data = [
            'title' => 'Enable 2FA',
            'qrCodeDataUri' => $qrCodeDataUri,
            'secret' => $secret
        ];

        return $this->render(
            $response,
            'auth/2fa-setup.php',
            $data
        );
    }

    public function verifyAndEnable(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        $user = SessionManager::get('user');

        $userId = $user['id'];
        $userEmail = $user['email'];

        // get setup secret
        $setupSecret = SessionManager::get(
            '2fa_setup_secret'
        );

        // expired setup
        if (!$setupSecret) {

            FlashMessage::error(
                '2FA setup expired.'
            );

            return $this->redirect(
                $request,
                $response,
                '2fa.setup'
            );
        }

        // create QR provider
        $qrProvider = new BaconQrCodeProvider(
            500,
            '#ffffff',
            '#000000',
            'svg'
        );

        // create TFA
        $twoFA = new TwoFactorAuth(
            $qrProvider,
            'BrewFinder'
        );

        // verify code
        $status = $twoFA->verifyCode(
            $setupSecret,
            $data['code']
        );

        // invalid code
        if (!$status) {

            $qrCodeDataUri = $twoFA
                ->getQRCodeImageAsDataUri(
                    $userEmail,
                    $setupSecret
                );

            $failed = [
                'title' => 'Enable 2FA',
                'error' => 'Invalid verification code. Please try again.',
                'qrCodeDataUri' => $qrCodeDataUri,
                'secret' => $setupSecret
            ];

            return $this->render(
                $response,
                'auth/2fa-setup.php',
                $failed
            );
        }

        // save secret if not existing
        $existing = $this->twoFactorModel
            ->findByUserId($userId);

        if (!$existing) {

            $this->twoFactorModel->create(
                $userId,
                $setupSecret
            );
        }

        // enable 2FA
        $this->twoFactorModel->enable(
            $userId
        );

        // remove temporary secret
        SessionManager::remove(
            '2fa_setup_secret'
        );

        FlashMessage::success(
            '2FA enabled successfully!'
        );

        return $this->redirect(
            $request,
            $response,
            'user.dashboard'
        );
    }

    public function showVerify(
        Request $request,
        Response $response
    ): Response {

        $data = [
            'title' => 'Verify Code'
        ];

        return $this->render(
            $response,
            'auth/2fa-verify.php',
            $data
        );
    }

    public function verify(
        Request $request,
        Response $response
    ): Response {

        $data = $request->getParsedBody();

        $user = SessionManager::get('user');
        $userId = $user['id'];

        // get stored secret
        $secret = $this->twoFactorModel->getSecret($userId);

        if (!$secret) {
            FlashMessage::error('No 2FA secret found.');

            return $this->redirect(
                $request,
                $response,
                'login'
            );
        }

        // create QR provider
        $qrProvider = new BaconQrCodeProvider(
            500,
            '#ffffff',
            '#000000',
            'svg'
        );

        // create TFA
        $twoFA = new TwoFactorAuth(
            $qrProvider,
            'BrewFinder'
        );

        // verify code
        $status = $twoFA->verifyCode(
            $secret,
            $data['code']
        );

        // invalid code
        if (!$status) {

            $attempts = (SessionManager::get('attempts') ?? 0) + 1;

            SessionManager::set('attempts', $attempts);

            if ($attempts >= 5) {

                SessionManager::destroy();

                FlashMessage::error('Too many failed attempts.');

                return $this->redirect(
                    $request,
                    $response,
                    'login'
                );
            }

            FlashMessage::error('Invalid Code');

            return $this->render(
                $response,
                'auth/2fa-verify.php'
            );
        }

        // SUCCESS: mark verified
        SessionManager::set('2fa_verified', true);

        // reset attempts
        SessionManager::set('attempts', 0);

        // regenerate session
        session_regenerate_id(true);

        /**
         * TRUST DEVICE LOGIC
         */
        $trustDevice = $data['trust_device'] ?? false;

        if ($trustDevice) {

            // 1. Generate secure device token
            $deviceToken = bin2hex(random_bytes(32));

            // 2. Expiration date (30 days)
            $expiresAt = date('Y-m-d H:i:s', strtotime('+30 days'));

            // 3. Device info using helpers
            $deviceInfo = [
                'name' => $this->getDeviceName($request),
                'user_agent' => $request->getHeaderLine('User-Agent'),
                'ip_address' => $this->getClientIp($request),
                'expires_at' => $expiresAt
            ];

            // 4. Save trusted device
            $this->trustedDeviceModel->create(
                $userId,
                $deviceToken,
                $deviceInfo
            );

            // 5. Set secure cookie
            setcookie(
                'trusted_device',
                $deviceToken,
                [
                    'expires' => time() + (30 * 24 * 60 * 60),
                    'path' => '/',
                    'httponly' => true,
                    'secure' => isset($_SERVER['HTTPS']),
                    'samesite' => 'Strict'
                ]
            );

            // 6. Update last used timestamp
            $this->trustedDeviceModel->updateLastUsed($deviceToken);
        }

        return $this->redirect(
            $request,
            $response,
            'user.dashboard'
        );
    }
    public function disable(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        $password = $data['password'] ?? null;

        if (!$password) {
            FlashMessage::error('Password is required');

            return $this->render(
                $response,
                'auth/2fa-disable.php'
            );
        }

        $sessionUser = SessionManager::get('user');

        if (!$sessionUser || empty($sessionUser['email'])) {
            FlashMessage::error('Session expired. Please log in again.');

            return $this->redirect($request, $response, 'login');
        }

        $user = $this->userModel->findByEmail($sessionUser['email']);

        if (
            !$user ||
            empty($user['password_hash']) ||
            !password_verify($password, $user['password_hash'])
        ) {
            FlashMessage::error('Invalid Credentials');

            return $this->render(
                $response,
                'auth/2fa-disable.php'
            );
        }

        // disable 2FA
        $this->twoFactorModel->disable($sessionUser['id']);
        FlashMessage::success('2FA disabled successfully!');

        return $this->redirect($request, $response, 'user.dashboard');
    }

    public function showDisable(
        Request $request,
        Response $response
    ): Response {

        return $this->render(
            $response,
            'auth/2fa-disable.php'
        );
    }

    private function getDeviceName(Request $request): string
    {
        $userAgent = $request->getHeaderLine('User-Agent');

        if (stripos($userAgent, 'Windows') !== false) return 'Windows PC';
        if (stripos($userAgent, 'Mac') !== false) return 'Mac';
        if (stripos($userAgent, 'iPhone') !== false) return 'iPhone';
        if (stripos($userAgent, 'Android') !== false) return 'Android';
        if (stripos($userAgent, 'Linux') !== false) return 'Linux PC';

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
