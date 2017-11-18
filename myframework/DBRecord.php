<?php

/**
 * Class DBRecord
 */
abstract class DBRecord extends Base
{
    const ROLE_PR_KEY = 1;
    const ROLE_UNDEFINED = -1;

    public $isNew = true;

    function __construct()
    {
        $this->makeProps();
    }

    /**
     * @return string
     */
    public abstract function tableName();

    public function save()
    {
        $idName = $this->getColNameByRole(self::ROLE_PR_KEY);
        $id = $this->data[$idName];
        unset($this->data[$this->getColNameByRole(self::ROLE_PR_KEY)]);

        if($this->isNew) {
            return $this->add();
        }

        $newValues = '';
        $variables = [];

        foreach ($this->data as $column => $value) {
            $newValues .= "$column=:$column,";
            $variables[$column] = $value;
        }
        $newValues = substr($newValues, 0, -1);

        if(DB::update($newValues, $variables, "$idName=$id", 1, $this->tableName())) {
            return true;
        }
        return false;
    }

    public function find($condition, $variables)
    {
        $result = $this->selectAll($condition, $variables, 1);
        $this->setData($result);
        return $result;
    }


    public function findAll($condition, $variables, $className, $limit = '')
    {
        $results = $this->selectAll($condition, $variables, $limit);
        $dataArr = [];
        do {
            /**
             * @var $model DBRecord
             */
            $model = new $className();
            $model->setData($results);
            if($model->isNew) break;
            $dataArr[] = $model;
        } while(true);
        return $dataArr;
    }

    public function selectAll($condition, $variables, $limit = '')
    {
        return DB::select($condition, $variables, $limit, $this->tableName());
    }

    public function findById($id)
    {
        $idColumnName = $this->getColNameByRole(self::ROLE_PR_KEY);
        $variables['id'] = $id;
        $condition = "$idColumnName = :id";
        $result = $this->find($condition, $variables);
        return boolval($result);
    }


    /**
     * @param $result mysqli_result
     * @return bool
     */
    public function setData($result)
    {
        $this->data = $result->fetch_assoc();
        if($this->data) {
            $this->isNew = false;
            $success = true;
        } else {
            $this->isNew = true;
            $success = false;
        }
        $this->makeProps();
        return $success;
    }

    protected $data;

    protected function makeProps()
    {
        // Create variables in data array, if object is new.
        if($this->isNew) {
            foreach (array_keys($this->getColumns()) as $column) {
                $this->data[$column] = '';
            }
        }
        foreach ($this->data as $column => &$value) {
            $this->{$column} = &$value;
        }
    }

    /**
     * @return array[column_name -> ROLE] -
     */
    protected abstract function getColumns();

    protected function getColNameByRole($role)
    {
        return array_search($role, $this->getColumns());
    }

    protected function add()
    {
        $columns = '';
        $values = '';
        $variables = [];
        foreach ($this->data as $column => $value) {
            $columns .= "$column,";
            $values .= ":$column,";
            $variables[$column] = $value;
        }
        $columns = substr($columns, 0, -1);
        $values = substr($values, 0, -1);

        if(DB::insert($columns, $values, $variables, $this->tableName())) {
            return true;
        }
        return false;
    }
}