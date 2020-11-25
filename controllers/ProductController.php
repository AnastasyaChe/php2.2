<?php


namespace app\controllers;


use app\models\Product;

class ProductController extends Controller
{
    public function actionIndex()
    {
        echo "catalog";
    }
    
    public function actionCard()
    {
        $id = $_GET['id'];
        $model = Product::getById($id);
        echo $this->render('product_card', ['model' => $model]);
    }

    
}