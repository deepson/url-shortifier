<?php


class DB {

    const TABLE ='links';

    /**
     * @var $connection mysqli
     */
    public static $connection = null;
    function __construct() {
        /** @var $conf string[] - fetching mysql parameters from app config. */
        $conf = App::$config['mysql'];

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        self::$connection = new mysqli;

        try {
            self::$connection->connect('localhost', $conf['user'], $conf['password'], $conf['database']);
        } catch (mysqli_sql_exception $e) {
            echo "Couldn't connect to mysql server. ";
            echo App::$production ? 'Disable production env int config to view stacktrace.' : 'Stack trace: ' . $e->getTraceAsString();
            die(-1);
        }
    }


    private static function select($condition = '', $limit = '', $table = self::TABLE, $columns = '*') {
        if($condition != '') {
            $condition = 'WHERE ' . $condition;
        }
        if($limit !== '') {
            $limit = 'LIMIT ' . intval($limit);
        }
        $sql = self::$connection->real_escape_string("SELECT `$columns` FROM `$table` $condition $limit");
        self::$connection->query($sql);
    }

    private static function update($id, $columnNames, $columns) {

    }


}