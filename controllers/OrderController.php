<?php


namespace app\controllers;


use app\models\Order;
use app\models\Product;
use app\models\User;
use app\services\Sessions;

class OrderController extends Controller
{
    public function actionIndex()
    {
        if (Sessions::get('user') != 'admin') {
            header("Location: http://shop/");
        }
        $orderId = Order::getAllNewOrderId();
        $orders = [];
        foreach($orderId as $value)
        {
            $orders[$value] = Order::getAllByOrderId($value);
        }

        echo $this->render('admin_orders_list',[
            'title' => 'Новые заказы',
            'session' => Sessions::getSessionInfo(),
            'orders' => $orders
        ]);
    }
    public function actionAddToCart()
    {
        $id = (int) $_GET['id'];
        $count = (int) $_POST['count'];
        $cart = Sessions::get("cart");
        $cart[$id] +=  $count;
        Sessions::set('cart', $cart);
        Sessions::set('quantity', Sessions::get('quantity') + $count);


        header("Location: http://shop/");
    }

    public function actionCart()
    {
        $products = [];
        $cart = Sessions::get('cart');

        $totalSum  = 0;

        foreach($cart as $key=>$value)
        {
            $products[$key] = Product::getDetailedOne($key);
            $products[$key]['quantity'] = $value;
            $products[$key]['totalPrice'] = $value * $products[$key]['price'];
            $totalSum += $value * $products[$key]['price'];
        }
        echo $this->render('cart', [
            'title' => 'Корзина',
            'products' => $products,
            'totalSum' => $totalSum,
            'session' => Sessions::getSessionInfo()
        ]);
    }

    public function actionDelete()
    {
        $id = (int) $_GET['id'];
        $cart = Sessions::get("cart");
        Sessions::set('quantity', Sessions::get('quantity') - $cart[$id]);
        unset($cart[$id]);
        Sessions::set('cart', $cart);

        $path = $_SERVER['HTTP_REFERER'];
        header("Location: $path");
    }

    public function actionCreate()
    {
        if($user = User::getByLogin(Sessions::get('user')))
        {
            $name = $user->name;
            $lastname = $user->lastname;
            $phone = $user->phone;
        } else {
            $name = $_POST['name'];
            $lastname = $_POST['lastname'];
            $phone = $_POST['phone'];
        }
        $orderId = Order::getLastOrderId() + 1;


        $cart = Sessions::get('cart');
        foreach ($cart as $key=>$value) {
            $order = new Order();
            $order->orderId = $orderId;
            $order->customerLogin = Sessions::get('user');
            $order->customerName = $name;
            $order->customerLastname = $lastname;
            $order->customerPhone = $phone;
            $order->productId = $key;
            $order->productQuantity = $value;

            $order->save();
        }
        Sessions::set('cart', []);
        Sessions::set('quantity', 0);
        header("Location: http://shop/");
    }

    public function actionComplete()
    {
        if (Sessions::get('user') != 'admin') {
            header("Location: http://shop/");
        }

        $orderId = (int) $_GET['id'];
        while ($order = Order::getNewOneByOrderId($orderId))
        {
            $order->status = 1;
            $order->save();
        }
        $path = $_SERVER['HTTP_REFERER'];
        header("Location: $path");
    }
}