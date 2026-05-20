<?php

namespace App\Controllers;

use App\Domain\Models\bookingModel;
use App\Domain\Models\ReviewsModel;
use App\Helpers\FlashMessage;
use App\Domain\Models\showModel;

use DI\Container;
use App\Helpers\SessionManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Controller for user stuff
 */
class userController extends BaseController
{
    /**
     * Constructor for user controller
     * @param Container $container
     * @param showModel $showModel
     * @param bookingModel $booking_model
     * @param ReviewsModel $reviewsModel
     */
    public function __construct(Container $container, private showModel $showModel, private bookingModel $booking_model, private ReviewsModel $reviewsModel)
    {
        parent::__construct($container);
    }

    public function index(Request $request, Response $response, array $args): Response
    {
        $info = $this->showModel->getAllPosters();

        return $this->render($response, 'admin/index.php', $info);
    }

    /**
     * Renders user shows page
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function renderUserShows(Request $request, Response $response, array $args): Response
    {
        $user = SessionManager::get('user');
        if (!empty($user['id'])) {

            $id = $this->booking_model->getTicketCountByUserId($user['id']);
            SessionManager::set('id', $id);
        }



        $data = $this->showModel->getAllPosters();
        return $this->render($response, 'user/userShows.php', ['data' => $data]);
    }

    /**
     * Renders show details page
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function renderShowDetails(Request $request, Response $response, array $args): Response
    {

        //this id is the actual show id
        $id = (int)$args['id'];
        //var_dump($id);

        // get the ID from URL
        $show = $this->showModel->getByShowId($id);


        $poster = $this->showModel->getPosterByShowId($id);
        $schedules = $this->showModel->getSchedulesByShowId($id);
        $reviews = $this->reviewsModel->getReviewsByShowId($id);

        $ratingData = $this->reviewsModel->getAverageRating($id);

        // fetch poster data
        return $this->render($response, 'user/show_details.php', ['show' => $show, 'poster' => $poster, 'schedules' => $schedules, 'reviews' => $reviews, 'ratingData' => $ratingData]);
    }
}
