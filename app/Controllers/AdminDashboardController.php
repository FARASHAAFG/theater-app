<?php

namespace App\Controllers;

use App\Domain\Models\AdminDashboardModel;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Controller for the admin dashboard
 */
class AdminDashboardController extends BaseController
{

    /**
     * Constructor for admin dashboard controller
     * @param Container $container
     * @param AdminDashboardModel $dashboardModel
     */
    public function __construct(
        Container $container,
        private AdminDashboardModel $dashboardModel
    ) {
        parent::__construct($container);
    }

    /**
     * Display the admin dashboard with e-commerce statistics.
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function dashboard(Request $request, Response $response, array $args): Response
    {
        $data = [
            'title' => t('admin.dashboard'),
            'totalShows' => $this->dashboardModel->getTotalShows(),
            'totalPosters' => $this->dashboardModel->getTotalPosters(),
            'totalShowings' => $this->dashboardModel->getTotalShowings(),
            'showsWithoutPoster' => $this->dashboardModel->getShowsWithoutPoster(),
            'upcomingShowings' => $this->dashboardModel->getUpcomingShowings(6),
            'username' => $_SESSION['username'] ?? 'Admin',
        ];

        return $this->render($response, 'admin/dashboard.php', $data);
    }
}
