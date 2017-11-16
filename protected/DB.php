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
            App::kill($e->getMessage() . ': ' . $e->getTraceAsString(), 'Couldn\'t connect to mysql server.');
        }
    }

    /**
     * @function replaces all combinations (separator . $varArray key) in $string with escaped $varArray value.
     * @param $string string - input string with separators and variable_names instead of variable values.
     * @param array(string=>string) $varArray - associative array [variable_name => variable_value] with query variables.
     * @param string $separator - variable declaration symbol in $string.
     * @return string - result safe string.
     */
    public static function fixInjections($string, $varArray, $separator = ':') {
        foreach ($varArray as $varName => $varValue) {
            $safeVarValue = self::$connection->real_escape_string($varValue);
            // Mark all values as strings.
            $safeVarValue = "'$safeVarValue'";
            $search = $separator . $varName;
            $string = str_replace($search, $safeVarValue, $string);
        }
        return $string;
    }

    /**
     * @function basic safe function wrapper for sql SELECT.
     * @param string $condition - 'WHERE' part of SQL query. You can use custom variables syntax.
     * @param array $variables - associative array [variable_name => variable_value] with query variables.
     * @param string $limit - SQL LIMIT
     * @param string $table - SQL table name.
     * @param string $columns - Names of columns which will be 'selected'.
     * @return bool|mysqli_result
     */
    public static function select($condition = '', $variables = [], $limit = '', $table = self::TABLE, $columns = '*') {
        if($condition != '') {
            $condition = 'WHERE ' . self::fixInjections($condition, $variables);
        }
        if($limit !== '') {
            $limit = 'LIMIT ' . intval($limit);
        }
        $sql = "SELECT $columns FROM `$table` $condition $limit";
        try {
            return self::$connection->query($sql);
        } catch (mysqli_sql_exception $e) {
            App::kill($e->getMessage() . ': ' . $e->getTraceAsString(), "Error in SELECT SQL query.");
            return false;
        }
    }

    /**
     * @function basic safe function wrapper for sql UPDATE.
     * @param string $newValues - expression like 'column=:col_value'
     * @param array $variables - associative array [variable_name => variable_value] with query variables.
     * @param string $condition - 'WHERE' part of SQL query. You can use custom variables syntax.
     * @param integer|string $limit - SQL LIMIT
     * @param string $table - SQL table name.
     * @return bool|mysqli_result
     */
    public static function update($newValues, $variables = [], $condition, $limit = '', $table = self::TABLE) {
        $condition = 'WHERE ' . self::fixInjections($condition, $variables);
        $newValues = self::fixInjections($newValues, $variables);
        if($limit !== '') {
            $limit = 'LIMIT ' . intval($limit);
        }
        $sql = "UPDATE `$table` SET $newValues $condition $limit";
        try {
            return self::$connection->query($sql);
        } catch (mysqli_sql_exception $e) {
            App::kill($e->getMessage() . ': ' . $e->getTraceAsString(), "Error in UPDATE SQL query.");
            return false;
        }
    }

    /**
     * @function basic safe function wrapper for sql INSERT.
     * @param string $columns - comma separated column names to insert.
     * @param string $values - comma separated values. You can use custom variables syntax.
     * @param array $variables - associative array [variable_name => variable_value] with query variables.
     * @param string $table - SQL table name.
     * @return bool|mysqli_result
     */
    public static function insert($columns, $values, $variables = [], $table = self::TABLE) {
        $values = self::fixInjections($values, $variables);
        $sql = "INSERT INTO `$table` ($columns) VALUES ($values)";
        try {
            return self::$connection->query($sql);
        } catch (mysqli_sql_exception $e) {
            App::kill($e->getMessage() . ': ' . $e->getTraceAsString() . " SQL: $sql", "Error in INSERT SQL query.");
            return false;
        }
    }

    // TODO: DELETE sql implementation (not needed in current task).

}