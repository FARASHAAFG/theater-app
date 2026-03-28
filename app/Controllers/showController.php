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

    public function init_add_poster(Request $request, Response $response, array $args): Response
    {
        $id = (int)$args['id'];
        $poster = $this->showModel->getById($id);
        return $this->render($response, 'admin/add_poster.php', ['poster' => $poster]);
    }

    //? Adds poster to database after form submission in add_poster.php
    public function createPoster(Request $request, Response $response, array $args): Response
    {
        $show_id = (int)$args['id'];
        $poster = $this->showModel->getById($show_id);
        $schedules = $this->showModel->getSchedulesByPosterId($show_id);

        $data = $request->getParsedBody();

        $poster_image = $data['poster_image'] ?? '';
        $is_used = $data['is_used'] ?? '';

        $errors = [];
        if (empty($poster_image)) {
            $errors[] = "Poster Image Required";
        }


        if (empty($errors)) {
            $this->showModel->createPoster($show_id, $poster_image, $is_used);

            return $this->render($response, 'admin/detail.php', ['poster' => $poster, 'schedules' => $schedules]);
        }

        return $this->view->render(
            $response,
            'admin/add_poster.php',
            [
                'errors' => $errors,
                'poster_image' => $poster_image,
                'show_id' => $show_id
            ]
        );
    }
    public function init_update_show(Request $request, Response $response, array $args): Response
    {
        $id = (int)$args['id'];
        $poster = $this->showModel->getById($id);
        $schedules = $this->showModel->getSchedulesByPosterId($id); // fetch poster data
        return $this->render($response, 'admin/update_show.php', ['poster' => $poster,   'schedules' => $schedules]);
    }

    public function update_show(Request $request, Response $response, array $args): Response
    {
        $show_id = (int)$args['id'];
        $poster = $this->showModel->getById($show_id);
        $schedules = $this->showModel->getSchedulesByPosterId($show_id);

        $data = $request->getParsedBody();

        $title_fr = $data['title_fr'] ?? '';
        $title = $data['title'] ?? '';
        $duration = $data['duration'] ?? '';
        $genre = $data['genre'] ?? '';
        $language = $data['language'] ?? '';
        $cast = $data['cast'] ?? '';
        $show_type = $data['show_type'] ?? '';
        $is_active = $data['is_active'] ?? '';
        $description = $data['description'] ?? '';
        $description_fr = $data['description_fr'] ?? '';


        $errors = [];
        // if (empty($poster_image)) {
        //     $errors[] = "Poster Image Required";
        // }


        if (empty($errors)) {
            $this->showModel->updateShow($title_fr, $title, $duration, $genre, $language, $cast, $show_type, $is_active, $description, $description_fr, $show_id);

            return $this->render($response, 'admin/detail.php', ['poster' => $poster, 'schedules' => $schedules]);
        }

        return $this->view->render(
            $response,
            'admin/update_show.php',
            [
                'errors' => $errors,
                'show_id' => $show_id
            ]
        );
    }

    public function init_add_show(Request $request, Response $response): Response
    {
        return $this->render($response, 'admin/add_show.php');
    }

    public function add_show(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $title_fr = $data['title_fr'] ?? '';
        $title = $data['title'] ?? '';
        $duration = $data['duration'] ?? '';
        $genre = $data['genre'] ?? '';
        $language = $data['language'] ?? '';
        $cast = $data['cast'] ?? '';
        $show_type = $data['show_type'] ?? '';
        $is_active = $data['is_active'] ?? '';
        $description = $data['description'] ?? '';
        $description_fr = $data['description_fr'] ?? '';


        $errors = [];
        // if (empty($poster_image)) {
        //     $errors[] = "Poster Image Required";
        // }


        if (empty($errors)) {
            $this->showModel->addShow($title_fr, $title, $duration, $genre, $language, $cast, $show_type, $is_active, $description, $description_fr);

            $info = $this->showModel->getAllPosters();
            return $this->render($response, 'admin/index.php', $info);
        }

        return $this->view->render(
            $response,
            'admin/update_show.php',
            [
                'errors' => $errors
            ]
        );
    }
}
