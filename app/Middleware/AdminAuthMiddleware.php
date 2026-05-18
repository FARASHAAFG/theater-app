<?php

namespace App\Middleware;

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
    public function __construct(private ResponseFactoryInterface $responseFactory) {}

    /**
     * Process the request - check if user is authenticated AND is an admin.
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        // TODO: Retrieve the user's authentication status and role from the session.
        $user = SessionManager::get('user', []);

        //       If not authenticated, redirect to the login page.
        //       If authenticated but not an admin, redirect to the user dashboard
        //       with an access denied message.
        //       If both checks pass, allow the request to proceed.
        //
        //       Use the same redirect pattern as AuthMiddleware (RouteParser + responseFactory).

        if (!$user || $user['role'] != 'admin') {
            FlashMessage::error('You do not have permission to access this page.');

            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            $dashboardUrl = $routeParser->urlFor('user.dashboard');

            $response = $this->responseFactory->createResponse(302);
            return $response->withHeader('Location', $dashboardUrl);
        }

        return $handler->handle($request);
    }
}
