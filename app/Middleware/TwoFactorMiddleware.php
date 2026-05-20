<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Domain\Models\TrustedDeviceModel;
use App\Domain\Models\TwoFactorAuthModel;
use App\Helpers\SessionManager;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Routing\RouteContext;

class TwoFactorMiddleware implements MiddlewareInterface
{
    public function __construct(
        private TwoFactorAuthModel $twoFactorModel,
        private ResponseFactoryInterface $responseFactory,
        private TrustedDeviceModel $trustedDeviceModel,
    ) {}

    public function process(
        Request $request,
        RequestHandler $handler
    ): ResponseInterface {

        // get session user
        $user = SessionManager::get('user');

        // not logged in
        if (
            !$user ||
            !($user['is_authenticated'] ?? false)
        ) {
            return $handler->handle($request);
        }

        $userId = $user['id'];

        // check if user has 2FA enabled
        $twoFactorEnabled = $this->twoFactorModel->isEnabled($userId);

        // already verified in session
        $twoFactorVerified = SessionManager::get('2fa_verified');

        /**
         * TRUSTED DEVICE CHECK (IMPORTANT)
         */
        $cookies = $request->getCookieParams();
        $deviceToken = $cookies['trusted_device'] ?? null;

        if ($twoFactorEnabled && $deviceToken) {

            if ($this->trustedDeviceModel->isValid($deviceToken, $userId)) {

                SessionManager::set('2fa_verified', true);

                $this->trustedDeviceModel->updateLastUsed($deviceToken);

                return $handler->handle($request);
            } else {

                // invalid or expired cookie → delete it
                setcookie('trusted_device', '', [
                    'expires' => time() - 3600,
                    'path' => '/',
                    'httponly' => true,
                    'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
                    'samesite' => 'Strict',
                ]);
            }
        }

        // if 2FA required but NOT verified, send to verification (avoid redirect loops)
        if ($twoFactorEnabled && !$twoFactorVerified) {
            $routeContext = RouteContext::fromRequest($request);
            $routeName = $routeContext->getRoute()?->getName() ?? '';

            $allowedDuringVerification = [
                '2fa.verify',
                '2fa.verify.post',
                '2fa.setup',
                '2fa.enable',
                'auth.logout',
            ];

            if (in_array($routeName, $allowedDuringVerification, true)) {
                return $handler->handle($request);
            }

            $routeParser = $routeContext->getRouteParser();
            $verifyUrl = $routeParser->urlFor('2fa.verify');

            return $this->responseFactory
                ->createResponse(302)
                ->withHeader('Location', $verifyUrl);
        }

        // continue request
        return $handler->handle($request);
    }
}
