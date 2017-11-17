<?php

require_once "../myframework/DBRecord.php";

/**
 * Class LinkModel
 * @property string link
 * @property string hash
 * @property int    hits
 * @property int    id
 */
class LinkModel extends DBRecord
{
    public function tableName()
    {
        return 'links';
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

    public function getShort() {
        return 'http://'.$_SERVER['SERVER_NAME'] . '/' . $this->hash;
    }

    public static function createShort($link)
    {
        $newHash = '';
        do {
            $newHash = self::genRandString();
            $exist = !self::byHash($newHash)->isNew;
        } while ($exist);
        $model = new LinkModel();
        $model->link = $link;
        $model->hash = $newHash;
        $model->hits = 0;
        $model->save();
        return $model;
    }

    public static function byHash($hash)
    {
        $model = new LinkModel();
        $model->find('hash = :hash', ['hash' => $hash]);
        return $model;
    }

    private static function genRandString($length = 6)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz_-+';
        $len = strlen($characters);
        $randString = '';
        for ($i = 0; $i < $length; $i++) {
            $randString .= $characters[rand(0, $len - 1)];
        }
        return $randString;
    }

}