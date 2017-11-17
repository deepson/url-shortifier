<?php

abstract class Base
{
    public static $layout = 'MainLayout';
    public static $siteName = 'Сократитель ссылок';
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
        $siteName = self::$siteName;

        self::renderPartial($view, $variables);

        $content = self::$renderBuffer;

        self::$renderBuffer = '';

        include self::$protected . self::$layout . '.php';
    }


    protected static $renderBuffer = '';
}