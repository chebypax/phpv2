<?php

namespace app\models;


use app\services\Db;

class Product extends DbModel///extends DbModel
{
    public $id;
    public $name;
    public $description;
    public $price;
    public $category;
    public $viewCount;


    /**
     * Product constructor.
     * @param $id
     * @param $name
     * @param $description
     * @param $price
     * @param $category
     */
    public function __construct($name = null, $description = null, $price = null, $category = null)
    {
        parent::__construct();
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->category = $category;
    }

    public static function getTableName()
    {
        return "products";
    }

    public static function getDetailedOne($id)
    {
        $tableName = static::getTableName();
        $imageTable = Image::getTableName();
        $categoryTable = Category::getTableName();
        $sql = "SELECT 
            {$tableName}.`id` AS `id`,
            {$tableName}.`name` AS `name`,
            {$tableName}.`description` AS `description`,
            {$tableName}.`price` AS `price`,
            {$tableName}.`category` AS `categoryId`,
            {$tableName}.`viewCount` AS `viewCount`,
            {$imageTable}.`name` AS `img_name`,
            {$imageTable}.`path` AS `img_path`,
            {$categoryTable}.`name` AS `category`
            FROM {$tableName} 
            INNER JOIN {$imageTable} ON ({$tableName}.`id` = {$imageTable}.`productId`) 
            INNER JOIN {$categoryTable} ON ({$tableName}.`category` = {$categoryTable}.`id`)
            WHERE {$tableName}.`id` = :id AND {$imageTable}.`avatar` = 1";
        return Db::getInstance()->queryOne($sql, [':id' => $id]);
    }

    public static function getDetailedAll()
    {
        $tableName = static::getTableName();
        $imageTable = Image::getTableName();
        $categoryTable = Category::getTableName();
        $sql = "SELECT 
            {$tableName}.`id` AS `id`,
            {$tableName}.`name` AS `name`,
            {$tableName}.`description` AS `description`,
            {$tableName}.`price` AS `price`,
            {$tableName}.`category` AS `categoryId`,
            {$tableName}.`viewCount` AS `viewCount`,
            {$imageTable}.`name` AS `img_name`,
            {$imageTable}.`path` AS `img_path`,
            {$categoryTable}.`name` AS `category`
 
            FROM {$tableName} 
            INNER JOIN {$imageTable} ON ({$tableName}.`id` = {$imageTable}.`productId`) 
            INNER JOIN {$categoryTable} ON ({$tableName}.`category` = {$categoryTable}.`id`)
            WHERE {$imageTable}.`avatar` = 1";
        return Db::getInstance()->queryAll($sql);
    }


}