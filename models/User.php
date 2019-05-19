<?php
namespace app\models;

use app\services\Db;

class User extends DbModel
{
    public $id;
    public $login;
    public $password;
    public $name;
    public $lastname;
    public $phone;
    public $email;

    public function __construct()
    {
        parent::__construct();
    }

    public static function getTableName()
    {
        return "users";
    }

    public static function getPersonalProperties()
    {
        $prop = parent::getPersonalProperties();
        $prop[] = 'password2';
        return $prop;
    }

    public static function getByLogin($login)
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE `login` = :login";
        return Db::getInstance()->queryObject($sql, [':login' => $login], get_called_class());
    }
}