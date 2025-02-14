<?php

require_once 'src/controllers/DefaultController.php';
require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/FilmController.php';
require_once 'src/controllers/PersonController.php';

class Routing{

    public static array $routes;


    public static function get(string $url, string $view){
        self::$routes[$url] = $view;
    }

    public static function post(string $url, string $view){
        self::$routes[$url] = $view;
    }

    public static function run(string $url) {

       $urlParts = explode("/", $url);
       $action = $urlParts[0];

        if(!array_key_exists($action, self::$routes)){
            die("Wrong url!"); 
        }

        $controller = self::$routes[$action];

        //tworzenie nowego kontrolera na podstawie stringa
        $object = new $controller;

        $action = $action ?: 'dashboard';

        $id = $urlParts[1] ?? '';

        $object->$action($id);
    }
}

