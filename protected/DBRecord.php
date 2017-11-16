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
        if($this->isNew) {
            return $this->add();
        }
        $idName = $this->getColNameByRole(self::ROLE_PR_KEY);
        $id = $this->data[$idName];
        unset($this->data[$this->getColNameByRole(self::ROLE_PR_KEY)]);

        $newValues = '';
        $variables = [];

        foreach ($this->data as $column => $value) {
            $newValues .= "$column=:$column,";
            $variables[$column] = $value;
        }
        $newValues = substr($newValues, 0, -1);
        DB::update($newValues, $variables, "$idName=$id", 1, $this->tableName());
    }

    public function findById($id)
    {
        $idColumnName = $this->getColNameByRole(self::ROLE_PR_KEY);
        $variables['id'] = $id;
        $condition = "$idColumnName = :id";
        $result = DB::select($condition, $variables, 1, $this->tableName());
        $this->data = $result->fetch_assoc();
        $this->isNew = false;
        $this->makeProps();
    }


    protected $data;

    protected $isNew = true;

    protected function makeProps()
    {
        foreach($this->data as $column => &$value)
        {
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

    }
}