<?php


namespace app\models;


use app\services\Db;

class Test extends DbModel
{
    public $id;
    public $name;
    public function __construct($name)
    {
        parent::__construct();

    }

    public static function getTableName()
{
    return 'test';
}

}