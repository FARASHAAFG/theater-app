<?php

namespace App\Controllers;

use App\Domain\Models\showModel;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ShowController extends BaseController
{
    public function __construct(Container $container, private showModel $showModel)
    {
        parent::__construct($container);
    }



    public function index(Request $request, Response $response, array $args): Response
    {
        $info = $this->showModel->getAllPosters();
        return $this->render($response, 'admin/index.php', $info);
    }
    public function show(Request $request, Response $response, array $args): Response
    {
        $id = (int)$args['id']; // get the ID from URL
        $poster = $this->showModel->getById($id);
        $schedules = $this->showModel->getSchedulesByPosterId($id); // fetch poster data
        return $this->render($response, 'admin/detail.php', ['poster' => $poster,   'schedules' => $schedules]);
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        $id = (int)$args['id'];
        $this->showModel->deleteById($id);

        // Redirect back to list page after deletion
        return $this->redirect($request, $response, 'show.index');
    }
}
