<?php

namespace App\Controllers;


use App\Helpers\FlashMessage;
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

    public function renderShows(Request $request, Response $response, array $args): Response
    {
        $shows = $this->showModel->getAllShows();
        return $this->render($response, 'admin/shows.php', $shows);
    }

    //* This the correct one, since it shows correct details and schedules, the other show function is the one that is wrong and needs to be fixed or removed
    public function renderShowDetails(Request $request, Response $response, array $args): Response
    {

        //this id is the actual show id
        $id = (int)$args['id']; // get the ID from URL
        $show = $this->showModel->getByShowId($id);
        $poster = $this->showModel->getPosterByShowId($id);
        $schedules = $this->showModel->getSchedulesByShowId($id); // fetch poster data
        return $this->render($response, 'admin/show_details.php', ['show' => $show, 'poster' => $poster, 'schedules' => $schedules]);
    }

    //! NEED TO FIX!! DOESNT ACC SHOW THE CORRECT DETAILS
    //! IT TAKES IN THE POSTER ID RATHER THAN THE SHOW ID SO IT SHOWS THE WRONG SCHEDULES...
    public function show(Request $request, Response $response, array $args): Response
    {
        // this is the poster id...
        $id = (int)$args['id']; // get the ID from URL
        $poster = $this->showModel->getById($id);
        $schedules = $this->showModel->getSchedulesByPosterId($id); // fetch poster data
        return $this->render($response, 'admin/detail.php', ['poster' => $poster,   'schedules' => $schedules]);
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        $id = (int)$args['id'];
        $this->showModel->deleteshowById($id);

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
            $this->showModel->createPoster($show_id, $is_used, $poster_image);

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
        $schedules = $this->showModel->getSchedulesByPosterId($id);

        return $this->render($response, 'admin/update_show.php', ['poster' => $poster,   'schedules' => $schedules]);
    }

    public function update_show(Request $request, Response $response, array $args): Response
    {
        $show_id = (int)$args['id'];
        $poster = $this->showModel->getById($show_id);
        $schedules = $this->showModel->getSchedulesByPosterId($show_id);

        $data = $request->getParsedBody();
        //var_dump($data);





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
        if (empty($title_fr)) {
            $errors[] = "French title is required.";
        }
        if (empty($title)) {
            $errors[] = "Title is required.";
        }
        if (empty($duration)) {
            $errors[] = "Duration is required.";
        } elseif (!is_numeric($duration) || (int)$duration <= 0) {
            $errors[] = "Duration must be a positive number.";
        }
        if (empty($genre)) {
            $errors[] = "Genre is required.";
        }
        if (empty($language)) {
            $errors[] = "Language is required.";
        }
        if (empty($show_type)) {
            $errors[] = "Show type is required.";
        }
        if (empty($description)) {
            $errors[] = "Description is required.";
        }
        if (empty($description_fr)) {
            $errors[] = "French description is required.";
        }





        // if (empty($poster_image)) {
        //     $errors[] = "Poster Image Required";
        // }



        if (empty($errors)) {
            $this->showModel->updateShow($title_fr, $title, $duration, $genre, $language, $cast, $show_type, $is_active, $description, $description_fr, $poster['show_id']);
            /*
            return $this->render($response, 'admin/detail.php', ['poster' => $poster, 'schedules' => $schedules]);

            */
            FlashMessage::success("This is a success message!");



            return $this->redirect($request, $response, 'show.index', ['id' => $show_id]);
        }
        if (!empty($errors)) {

            //return $this->redirect($request, $response, 'show.index');
            FlashMessage::error(implode(', ', $errors));

            return $this->redirect($request, $response, 'show.update', ['error' => $errors,  'id' => $show_id]);
        }
        return $this->redirect($request, $response, 'show.index');

        /*
        return $this->view->render(
            $response,
            'admin/update_show.php',
            [
                'errors' => $errors,
                'show_id' => $show_id
            ]
        );
        */
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
        if (empty($title_fr)) {
            $errors[] = "French title is required.";
        }
        if (empty($title)) {
            $errors[] = "Title is required.";
        }
        if (empty($duration)) {
            $errors[] = "Duration is required.";
        } elseif (!is_numeric($duration) || (int)$duration <= 0) {
            $errors[] = "Duration must be a positive number.";
        }
        if (empty($genre)) {
            $errors[] = "Genre is required.";
        }
        if (empty($language)) {
            $errors[] = "Language is required.";
        }
        if (empty($show_type)) {
            $errors[] = "Show type is required.";
        }
        if (empty($description)) {
            $errors[] = "Description is required.";
        }
        if (empty($description_fr)) {
            $errors[] = "French description is required.";
        }



        // if (empty($poster_image)) {
        //     $errors[] = "Poster Image Required";
        // }


        if (empty($errors)) {
            $this->showModel->addShow($title_fr, $title, $duration, $genre, $language, $cast, $show_type, $is_active, $description, $description_fr);
            /*

            $info
            $this->showModel->getAllPosters();
            return $this->render($response, 'admin/index.php', $info);
            */
            return $this->redirect($request, $response, 'show.index');
        }


        /*
        return $this->view->render(
            $response,
            'admin/update_show.php',
            [
                'errors' => $errors
            ]
        );
        */ else if (!empty($errors))
            FlashMessage::error("Please fill all the blocks");
        return $this->redirect($request, $response, 'show.add', [
            'errors' => $errors
        ]);
        return $this->redirect($request, $response, 'show.index');
    }
}
