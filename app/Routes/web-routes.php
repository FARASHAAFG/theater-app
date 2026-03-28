<?php

declare(strict_types=1);

/**
 * This file contains the routes for the web application.
 */

use App\Controllers\HomeController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controllers\ShowController;






return static function (Slim\App $app): void {



    //* NOTE: Route naming pattern: [controller_name].[method_name]




    $app->get('/', [HomeController::class, 'index'])
        ->setName('home.index');
    $app->get('/show', [ShowController::class, 'index'])
        ->setName('show.index');
    $app->get('/detail/{id}', [ShowController::class, 'show'])->setName('show.detail');
    $app->get('/show/delete/{id}', [ShowController::class, 'delete'])
        ->setName('show.delete');

    $app->get('/home', [HomeController::class, 'index'])
        ->setName('home.index');

    $app->get('/add_poster/{id}', [ShowController::class, 'init_add_poster']);

    $app->post('/add_poster/{id}', [ShowController::class, 'createPoster']);

    $app->get('/update_show/{id}', [ShowController::class, 'init_update_show']);

    $app->post('/update_show/{id}', [ShowController::class, 'update_show']);

    $app->get('/add_show', [ShowController::class, 'init_add_show']);

    $app->post('/add_show', [ShowController::class, 'add_show']);

    // A route to display PHP configuration information.
    $app->get('/phpinfo', function (Request $request, Response $response, $args) {
        ob_start();
        phpinfo();
        $phpinfo = ob_get_clean();
        $response->getBody()->write($phpinfo);
        return $response;
    });

    // A route to test runtime error handling and custom exceptions.
    $app->get('/error', function (Request $request, Response $response, $args) {
        throw new \Slim\Exception\HttpBadRequestException($request, "This is a runtime error. Something went wrong");
    });
};
