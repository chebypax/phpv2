<?php


namespace app\controllers;


class GalleryController extends Controller
{
    public function actionIndex() {
        echo $this->render('gallery', [
            'product' => 'Тут будут товары',
            'title' => 'Главная'
            ]);
    }
}