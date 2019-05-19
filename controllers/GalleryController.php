<?php


namespace app\controllers;


use app\services\Sessions;

class GalleryController extends Controller
{
    public function actionIndex() {
        echo $this->render('gallery', [
            'product' => 'Тут будут товары',
            'title' => 'Главная',
            'session' => Sessions::getSessionInfo()
            ]);
    }
}