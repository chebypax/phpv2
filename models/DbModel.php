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
        $sql = "SELECT * FROM {$tableName} WHERE `id` = :id";
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
        $sql = "DELETE FROM {$tableName} WHERE `id` = :id";
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
        $exec = $this->db->execute($sql, $params);
        $this->id = $this->db->lastInsertId();
        return $exec;
    }


    public function update()

        {
            $params = [];
            $columns = [];
            $sql = "";
            foreach ($this as $key => $value) {
                if (in_array($key, static::getPersonalProperties())) {
                    continue;
                }
                $sql .= "`{$key}` = :{$key}, ";

                $params[":{$key}"] = $value;
                $columns[] = "`{$key}`";
            }
            $tableName = static::getTableName();
            $sql = substr($sql, 0, strlen($sql) - 2);
            $sql = "UPDATE `{$tableName}` SET $sql WHERE `id` = $this->id";
            $exec = $this->db->execute($sql, $params);
            $this->id = $this->db->lastInsertId();
            return $exec;
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
        return ['db'];
    }

}