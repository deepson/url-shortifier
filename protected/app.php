<?php

require_once 'DB.php';

final class App {
    public static $config;
    public static $production = true;
    public static $db;
    function __construct() {
        error_reporting('E_ALL');

        self::$config = include 'config.php';
        self::$production = self::$config['production'];

        self::$db = new DB();
    }
}
