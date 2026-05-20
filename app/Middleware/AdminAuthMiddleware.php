<?php

namespace App\Middleware;

use App\Domain\Models\TwoFactorAuthModel;
use App\Helpers\FlashMessage;
use App\Helpers\SessionManager;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Routing\RouteContext;

class AdminAuthMiddleware implements MiddlewareInterface
{
    public function __construct(
        private ResponseFactoryInterface $responseFactory,
        private TwoFactorAuthModel $twoFactorModel
    ) {}

    public function process(Request $request, RequestHandler $handler): Response
    {
        $user = SessionManager::get('user', []);

        // not logged in OR not admin
        if (!$user || ($user['role'] ?? null) !== 'admin') {

            FlashMessage::error('You do not have permission to access this page.');

            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            $dashboardUrl = $routeParser->urlFor('user.dashboard');

            $response = $this->responseFactory->createResponse(302);
            return $response->withHeader('Location', $dashboardUrl);
        }

        $userId = $user['id'];
        if (!$this->twoFactorModel->isEnabled($userId)) {

            FlashMessage::warning(
                'Admin accounts require Two-Factor Authentication. Please enable 2FA to continue.'
            );

            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            $setupUrl = $routeParser->urlFor('2fa.setup');

            $response = $this->responseFactory->createResponse(302);
            return $response->withHeader('Location', $setupUrl);
        }

        return $handler->handle($request);
    }
}
