<?php

/**
 * Class DBRecord
 */
abstract class DBRecord
{
    const ROLE_PR_KEY = 1;
    const ROLE_UNDEFINED = -1;


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

    public function findById($id)
    {
        $idColumnName = $this->getColNameByRole(self::ROLE_PR_KEY);
        $variables['id'] = $id;
        $condition = "$idColumnName = :id";
        $result = DB::select($condition, $variables, 1, $this->tableName());
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

    protected $isNew = true;

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