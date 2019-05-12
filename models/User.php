<?php
namespace app\models;

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
}