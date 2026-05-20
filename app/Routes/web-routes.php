<?php

declare(strict_types=1);

/**
 * This file contains the routes for the web application.
 */

use App\Controllers\HomeController;
use App\Controllers\UploadController;
use App\Controllers\userController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controllers\ShowController;
use App\Controllers\AdminDashboardController;
use App\Controllers\AuthController;
use App\Controllers\BookingController;
use App\Middleware\AuthMiddleware;
use App\Middleware\AdminAuthMiddleware;
use App\Controllers\TwoFactorController;
use App\Middleware\TwoFactorMiddleware;




return static function (Slim\App $app): void {



    $app->get('/booking', [BookingController::class, 'index'])
        ->setName('booking.index');

    $app->get('/booking/add', [BookingController::class, 'add'])
        ->setName('booking.add');


    $app->get('/booking/update', [BookingController::class, 'update'])
        ->setName('booking.update');

    $app->get('/booking/remove', [BookingController::class, 'remove'])
        ->setName('booking.remove');
    $app->get('/booking/clear', [BookingController::class, 'clear'])
        ->setName('booking.clear');


    $app->get('/', [HomeController::class, 'index'])
        ->setName('home.index');

    // searching
    $app->get('/shows/search', [ShowController::class, 'search'])->setName('show.search');

    $app->group('/user', function ($group) {
        $group->get('/shows', [userController::class, 'renderUserShows'])
            ->setName('posters.index');
        $group->get('/show_details/{id}', [userController::class, 'renderShowDetails']);
        $group->get('/booking/{id}', [BookingController::class, 'getScheduleForBooking'])->setName('schedule.select');



        $group->post('/seats', [BookingController::class, 'seatSelect'])->setName('seat.select');

        $group->post('/booking', [BookingController::class, 'renderSeat'])->setName('seat.book')->setName('booking');
    });

    //* Register & Login Routes
    $app->get('/register', [AuthController::class, 'register'])
        ->setName('auth.register');
    $app->post('/register', [AuthController::class, 'store']);

    $app->get('/login', [AuthController::class, 'login'])
        ->setName('auth.login');
    $app->post('/login', [AuthController::class, 'authenticate']);
    $app->get('/logout', [AuthController::class, 'logout'])
        ->setName('auth.logout');

    $app->get('/dashboard', [AuthController::class, 'dashboard'])
        ->setName('user.dashboard')
        ->add(TwoFactorMiddleware::class)
        ->add(AuthMiddleware::class);
    // 2FA Routes
    $app->get('/2fa/setup', [TwoFactorController::class, 'showSetup'])
        ->setName('2fa.setup')
        ->add(AuthMiddleware::class);

    $app->post('/2fa/verify-and-enable', [TwoFactorController::class, 'verifyAndEnable'])
        ->setName('2fa.enable')
        ->add(AuthMiddleware::class);

    $app->get('/2fa/verify', [TwoFactorController::class, 'showVerify'])
        ->setName('2fa.verify')
        ->add(AuthMiddleware::class);

    $app->post('/2fa/verify', [TwoFactorController::class, 'verify'])
        ->setName('2fa.verify.post')
        ->add(AuthMiddleware::class);

    $app->get('/2fa/disable', [TwoFactorController::class, 'showDisable'])
        ->setName('2fa.disable.show')
        ->add(TwoFactorMiddleware::class)
        ->add(AuthMiddleware::class);

    $app->post('/2fa/disable', [TwoFactorController::class, 'disable'])
        ->setName('2fa.disable')
        ->add(TwoFactorMiddleware::class)
        ->add(AuthMiddleware::class);
    //! -------------------------- //
    // TODO: Review these routes
    /*$app->group('/checkout', function ($group) {
        $group->get('', [Book::class, 'checkout']);
        $group->post('', [CartController::class, 'processCheckout']);
    })->add(AuthMiddleware::class);*/
    //! -------------------------- //

    //$app->get('/shows', [ShowController::class, 'renderShows']);
    $app->group('/admin', function ($group) {
        //       - Named route: 'upload.index'
        $group->get('/upload/{id}', [UploadController::class, 'index'])
            ->setName('upload.index');



        // TODO: Add POST route for /upload
        //       - Controller: UploadController::class, 'upload'
        //       - Named route: 'upload.process'

        $group->post('/upload/{id}', [UploadController::class, 'upload'])
            ->setName('upload.process');


        $group->get('', [AdminDashboardController::class, 'dashboard'])
            ->setName('admin.dashboard');

        $group->get('/posters', [ShowController::class, 'index'])
            ->setName('posters.index');

        $group->get('/shows', [ShowController::class, 'renderShows'])->setName('show.index');

        $group->get('/detail/{id}', [ShowController::class, 'show'])->setName('show.detail');

        $group->get('/show/delete/{id}', [ShowController::class, 'delete'])
            ->setName('show.delete');

        $group->get('/show_details/{id}', [ShowController::class, 'renderShowDetails']);

        $group->get('/add_poster/{id}', [ShowController::class, 'init_add_poster']);

        $group->post('/add_poster/{id}', [ShowController::class, 'createPoster']);

        $group->get('/update_show/{id}', [ShowController::class, 'init_update_show']);

        $group->post('/update_show/{id}', [ShowController::class, 'update_show'])->setName('show.update');

        $group->get('/add_show', [ShowController::class, 'init_add_show']);

        $group->post('/add_show', [ShowController::class, 'add_show'])->setName('show.add');

        //* Auth
        $group->get('/dashboard', [AdminDashboardController::class, 'dashboard'])->setName('admin.dashboard');
    })->add(TwoFactorMiddleware::class)
        ->add(AdminAuthMiddleware::class)
        ->add(AuthMiddleware::class);







    //* NOTE: Route naming pattern: [controller_name].[method_name]




    /*

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
    */

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
