<?php
namespace app\models;

class User extends Record
{
    public $name;
    public $email;
    public $login;
    public $password;



    public static function getByLogin($login, $password) {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE login = :login, password = :password";
        return  static::getQuery($sql, [':login' => $login, ':password' => $password])[0];
    }

    public static function getTableName(): string
    {
        return "users";
    }
}