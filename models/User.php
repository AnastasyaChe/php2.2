<?php
namespace app\models;

class User extends Record
{
    public $name;
    public $email;

    public function getByLogin($login) {

    }

    public static function getTableName(): string
    {
        return "users";
    }
}