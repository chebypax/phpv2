<?php

namespace app\models;

use app\interfaces\IDbModel;
use app\services\Db;

/**
 * Class DbModel
 * @package app\models
 */
abstract class DbModel implements IDbModel
{

    /** @var  Db */
    protected $db;
    /**
     * Product constructor.
     * @param $db
     */
    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    public static function getOne($id)
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE id = :id";
        return Db::getInstance()->queryObject($sql, [':id' => $id], get_called_class());
    }

    public static function getAll()
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName}";
        return Db::getInstance()->queryAll($sql);
    }

    public function delete()
    {
        $tableName = static::getTableName();
        $sql = "DELETE FROM {$tableName} WHERE id = :id";
        return $this->db->execute($sql, [":id" => $this->id]);
    }

    public function insert()
    {
        $params = [];
        $columns = [];
        foreach ($this as $key => $value) {
           if (in_array($key, static::getPersonalProperties())) {
                continue;
            }

            $params[":{$key}"] = $value;
            $columns[] = "`{$key}`";
        }
        $columns = implode(", ", $columns);
        $placeholders = implode(", ", array_keys($params));

        $tableName = static::getTableName();
        $sql = "INSERT INTO `{$tableName}` ({$columns}) VALUES ({$placeholders})";
        $this->db->execute($sql, $params);
        $this->id = $this->db->lastInsertId();
        return true;
    }


    public function update()
    {
        $tableName = static::getTableName();
        $params = [];

        foreach ($this as $key => $value) {
            if (in_array($key, static::getPersonalProperties())) {
                continue;
            }
            $params[":{$key}"] = $value;
            $sql = "UPDATE `{$tableName}` SET `{$key}` = :{$key}  WHERE `id` = :id";
            $this->db->execute($sql, [":{$key}"=> $value, ":id"=> $this->id]);
            $params[":{$key}"] = $value;
        }
        return true;
    }

    public function save(){
        if($this->id){
            return $this->update();
        }else{
            return $this->insert();
        }
    }

    public static function getPersonalProperties()
    {
        return ['db', 'password2'];
    }

}