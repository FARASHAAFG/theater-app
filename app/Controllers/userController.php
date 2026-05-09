<?php

namespace App\Controllers;


use App\Helpers\FlashMessage;
use App\Domain\Models\showModel;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class userController extends BaseController
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


    public function renderUserShows(Request $request, Response $response, array $args): Response
    {
        $data = $this->showModel->getAllPosters();
        return $this->render($response, 'user/userShows.php', ["data" => $data]);
    }


    public function renderShowDetails(Request $request, Response $response, array $args): Response
    {

        //this id is the actual show id
        $id = (int)$args['id'];
        //var_dump($id);

        // get the ID from URL
        $show = $this->showModel->getByShowId($id);


        $poster = $this->showModel->getPosterByShowId($id);
        $schedules = $this->showModel->getSchedulesByShowId($id);

        // fetch poster data
        return $this->render($response, 'user/show_details.php', ['show' => $show, 'poster' => $poster, 'schedules' => $schedules]);
    }

}
