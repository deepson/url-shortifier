<?php

require_once "DBRecord.php";

/**
 * Class LinkModel
 * @property string link
 */
class LinkModel extends DBRecord
{
    public function tableName()
    {
        return 'links';
    }

    public function getLink() {
        return $this->data["link"];
    }

    protected  function getColumns()
    {
        return [
            'id' => self::ROLE_PR_KEY,
            'link' => self::ROLE_UNDEFINED,
            'hash' => self::ROLE_UNDEFINED,
            'hits' => self::ROLE_UNDEFINED,
        ];
    }


}