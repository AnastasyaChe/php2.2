<?php
namespace app\models;

class Orders extends Record
{
    public $id;
    public $user_id;
    public $product_id;
    public $count;
      

    public static function getTableName(): string
    {
        return "orders";
    }
}