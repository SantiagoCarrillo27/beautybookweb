<?php


namespace Controllers;

use MVC\Router;


class LandingController {
    public static function index(Router $router)
    {
        $router->render('landing/index', [
            'titulo' => 'Landing Page'
        ]);
    }
}