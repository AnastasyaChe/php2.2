<?php


namespace app\models;


use app\base\Session;
use app\models\repositories\ProductRepository;

class Basket
{
    public function getItems()
    {
        $session = new Session();
        $basket = [];
        $productIds = [];

        if ($session->exists('basket')) {
            $items = $session->get('basket');
            $productIds = array_filter(
                array_keys($items),
                function ($element) {
                    return is_int($element);
                }
            );
        }

        if($productIds) {
            $products = (new ProductRepository())->getByIds($productIds);
            foreach ($products as $product) {
                $basket[] = [
                    'product' => $product,
                    'qty' => $items[$product['id']]
                ];
            }
        }

        return $basket;
    }

    public function add($productId, $productQty)
    {
        $session = new Session();

        $basket = $session->get('basket');

        if(isset($basket[$productId])) {
            $basket[$productId] += $productQty;
        } else {
            $basket[$productId] = $productQty;
        }
        $session->set('basket', $basket);
    }
}