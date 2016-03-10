<?php

namespace App;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class HomeController
{
    public function home(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        // Do your stuff here
        return $this->view->render($response, 'home.twig');

        // return $response;
    }
}
