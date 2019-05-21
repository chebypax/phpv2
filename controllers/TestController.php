<?php


namespace app\controllers;


use app\models\Category;
use app\models\Image;
use app\models\Order;
use app\models\Product;
use app\models\Test;
use app\services\Db;


class TestController extends Controller
{
    public function actionIndex()
    {
//        $db = new Db();
//        $db->getConnection();
//        $sql = "INSERT INTO `test` (`name`) VALUES ('newtext')";
//        $db->execute($sql);
//        var_dump($db);

//        $orderId = Order::getLastOrderId();
//        var_dump($orderId); exit;
//        $a = Order::getNewOneByOrderId(1);
//        var_dump($a); exit;
session_start();
session_destroy();

    }
}