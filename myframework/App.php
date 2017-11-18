<?php

require_once 'DB.php';
require_once 'Base.php';

// TODO: This class to complete MVC.

final class App extends Base
{
    public static $config;
    public static $production;
    public static $db;
    public static $routes;
    function __construct()
    {
        // Load application configuration.
        self::$config = include '../protected/config.php';
        self::$production = self::$config['production'];

        if(!self::$production) {
            error_reporting('E_ALL');
        }

        // Initialize DB connection
        self::$db = new DB();

        foreach (self::$config['models'] as $model) {
            require_once "../protected/$model.php";
        }
        foreach (self::$config['controllers'] as $name => $route) {
            require_once "../protected/$name.php";
        }
    }
    public static function kill($devMsg, $prodMsg, $both = '', $responseCode = 500, $title , $partial=false)
    {
        http_response_code($responseCode);

        $err = self::$production ? $prodMsg : $devMsg;

        $err =  '<div style="padding: 5px 10px; background-color: #ab4d14; color: white;">ОШИБКА: ' . $both . $err . '</div>';

        if($partial) {
            echo $err;
        } else {
            self::renderError($err, $title);
        }

        die();
    }
    public static function registerController($route, $obj)
    {
        self::$routes[] = [
            'route' => $route,
            'object' => $obj
        ];
    }
    public static function routeUrl($url)
    {
        foreach (self::$routes as $route) {
            if($url === $route['route']) {
                //$route['object']->tryAction;
            }
        }
    }
    function __destruct()
    {
        echo Base::$renderBuffer;
    }
}

new App;