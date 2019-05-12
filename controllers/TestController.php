<?php


namespace app\controllers;


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
        $test = Test::getOne(1);
        var_dump($test);


    }
}