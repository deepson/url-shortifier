<?php

abstract class Base
{
    public static $layout = 'MainLayout';
    public static $parameters = [];
    public static $protected = '../protected/';
    public static function renderPartial($view, $variables = [])
    {
        extract($variables);
        ob_start();
        include self::$protected . $view . '.php';
        self::$renderBuffer .= ob_get_clean();

    }
    public static function render($view, $variables = [])
    {
        $siteName = App::$config['sitename'];

        self::renderPartial($view, $variables);

        $content = self::$renderBuffer;

        self::$renderBuffer = '';

        include self::$protected . self::$layout . '.php';
    }

    public static function renderError($msg, $title = '')
    {
        self::$renderBuffer = $msg;

        include self::$protected . self::$layout . '.php';
    }

    public static function getPath()
    {
        $path = '';
        $match = [];
        preg_match('/^\A[a-zA-Z0-9\/_\-+]*/', $_SERVER['REQUEST_URI'], $match);
        $path = substr($match[0], 1);
        return $path;
    }

    protected static $renderBuffer = '';
}