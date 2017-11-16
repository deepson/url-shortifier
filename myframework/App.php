<?php

require_once 'DB.php';
require_once 'Base.php';

final class App extends Base {
    public static $config;
    public static $production;
    public static $db;
    function __construct() {
        // Load application configuration.
        self::$config = include '../protected/config.php';
        self::$production = self::$config['production'];

        if(!self::$production) {
            error_reporting('E_ALL');
        }

        // Initialize DB connection
        self::$db = new DB();
    }
    public static function kill($devMsg, $prodMsg) {
        echo 'FATAL: ';
        echo self::$production ? $prodMsg : $devMsg;
        //TODO: render view here
        die();
    }
}

new App;