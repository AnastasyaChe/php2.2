<?php


namespace app\controllers;


use app\models\Product;

class BasketController extends Controller
{
    

    public function actionIndex()
    {
        $basket = [];
        if (!empty($_SESSION['basket'])) {
            $productIds = array_filter(
                array_keys($_SESSION['basket']),
                function ($element) {
                    return is_int($element);
                }
            );
            $products = Product::getAllProducts($productIds);
            foreach ($products as $product) {
                $basket[] = [
                    'product' => $product,
                    'qty' => $_SESSION['basket'][$product['id']]
                ];
            }
        }
        echo $this->render('basket', ['basket' => $basket]);
    }
    public function actionAdd() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $productId = $_POST['id'];
            $productQty = $_POST ['qty'];
            
            if(isset($_SESSION['basket'][$productId])) {
                $_SESSION['basket'][$productId] +=$productQty;
            
        
            }else {
                $_SESSION['basket'][$productId] = $productQty;
            
            }  
        }
    }
    
    

    
}