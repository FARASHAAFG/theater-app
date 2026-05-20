<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Domain\Models\ReviewsModel;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Controller for home page
 */
class HomeController extends BaseController
{
    //NOTE: Passing the entire container violates the Dependency Inversion Principle and creates a service locator anti-pattern.
    // However, it is a simple and effective way to pass the container to the controller given the small scope of the application and the fact that this application is to be used in a classroom setting where students are not yet familiar with the Dependency Inversion Principle.

    /**
     * Constructor for home controller
     * @param Container $container
     * @param ReviewsModel $reviewsModel
     */
    public function __construct(Container $container, private ReviewsModel $reviewsModel)
    {
        parent::__construct($container);
    }

    /**
     * Renders home page
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function index(Request $request, Response $response, array $args): Response
    {
        //$data['flash'] = $this->flash->getFlashMessage();
        //echo $data['message'] ;exit;
        $topRatedShows = $this->reviewsModel->getTopRatedShows();

        $data = [
            'title' => 'Home',
            'message' => 'Welcome to the home page',
            'topRatedShows' => $topRatedShows
        ];

        //dd($data);
        //var_dump($this->session); exit;
        return $this->render($response, 'homeView.php', $data);
    }

    /**
     * Renders error view
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function error(Request $request, Response $response, array $args): Response
    {

        return $this->render($response, 'errorView.php');
    }
}
