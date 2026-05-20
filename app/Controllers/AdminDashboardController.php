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
        // TODO: Call the model methods to get dashboard statistics
        //   - Total products     → $this->dashboardModel->getTotalProducts()
        //   - Total categories   → $this->dashboardModel->getTotalCategories()
        $totalShows = $this->dashboardModel->getTotalShows();
        $totalPosters = $this->dashboardModel->getTotalPosters();

        // TODO: Build a $data array with the following keys:
        //   - 'title'            => 'Admin Dashboard'
        //   - 'totalProducts'    => (from model)
        //   - 'totalCategories'  => (from model)
        //   - 'username'         => $_SESSION['username'] ?? 'Admin'

        $data = [
            'title' => 'Admin Dashboard',
            'totalShows' => $totalShows,
            'totalPosters' => $totalPosters,
            'username' => $_SESSION['username'] ?? 'Admin'
        ];

        // TODO: Render the view 'admin/dashboardView.php' and pass the $data array
        return $this->render($response, 'admin/dashboard.php', $data);
    }
}
