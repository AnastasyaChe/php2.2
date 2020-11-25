<?php

namespace app\models;

class Product extends Record
{
    public $id;
    public $name;
    public $description;
    public $price;
    public $category_id;

    public function getByCategoryId(int $categoryId)
    {
    }

    public static function getTableName(): string
    {
        return "gallery";
    }
}
