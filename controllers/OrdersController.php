<?php


namespace app\controllers;


use app\base\Request;
use app\models\Product;
use app\models\repositories\OrdersRepository;
use app\models\repositories\ProductRepository;

class OrdersController extends Controller
{
    public function actionIndex()
    {   $basket = [];
        if(!empty($_SESSION['basket'])) {
            $productIds = array_filter(
                array_keys($_SESSION['basket']),
                function ($element) {
                    return is_int($element);
                }
            );
            $products = (new OrdersRepository())->getByIds($productIds);
            foreach($products as $product){
                
                $basket[] = [
                    'product' => $product,
                    'qty' => $_SESSION['basket'][$product['id']]
                ];
               
            }
            
        }
        echo $this->render('product_card', ['basket' => $basket]); 
    }
    public function actionChangeQty()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $newData = $_POST('quantity');
            
            foreach($newData as $key => $val) {
                if($val == 0) {
                    unset($_SESSION['basket'][$key]);
                } else {
                    $_SESSION['basket'][$key] = $val;
                }
            }
        }
    }

    
}