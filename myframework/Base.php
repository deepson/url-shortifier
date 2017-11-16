<?php

abstract class Base
{
    public static $layout = '../protected/MainLayout.php';
    public static function render($view, $variables = [], $partial = false) {
        ob_start();
        include $view;
        $content = ob_get_clean();
        include self::$layout;
    }
}