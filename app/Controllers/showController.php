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
        return $this->render($response, 'Shops/index.php', $info);
    }
}
