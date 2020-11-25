<?php
namespace app\models;

class UserInfo extends Record
{
    public $id;
    public $fio;
    public $adress;
    public $phone;
    public $email;

    

    public static function getTableName(): string
    {
        return "user_info";
    }
}