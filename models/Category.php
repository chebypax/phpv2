<?php


namespace app\models;


class Category extends DbModel
{
    public function __construct()
    {
        parent::__construct();
    }

    public static function getTableName()
    {
        return "categories";
    }
}