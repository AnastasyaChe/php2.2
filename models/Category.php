<?php
namespace app\models;

class Category extends Record
{
    public $id;
    public $category;
    public $discount;
        

    public static function getTableName(): string
    {
        return "catagory";
    }
}