<?php

namespace app\controllers;

use app\models\Image;
use app\models\Product;
use app\models\User;
use app\services\Sessions;

class ProductController extends Controller
{

    public function actionIndex()
    {
        $products = Product::getDetailedAll();
        echo $this->render('gallery', [
            'products' => $products,
            'title' => 'Главная',
            'session' => Sessions::getSessionInfo()
        ]);
    }

    public function actionCard()
    {
        $id = $_GET['id'];
        $product = Product::getDetailedOne($id);
        $images = Image::getAllByProduct($id);
        echo $this->render('product_card', [
            'title' => $product['name'],
            'product' => $product,
            'images' => $images,
            'session' => Sessions::getSessionInfo()]);
    }

    public function actionAdd()
    {
        echo $this->render('product_create', [
            'title' => 'Добавить товар',
            'session' => Sessions::getSessionInfo()
        ]);
    }

    public function actionCreate()
    {
        if (Sessions::get('user') != 'admin') {
            return header("Location: http://shop/");
        }
        $props = $_POST;
        $item = new Product();
        foreach ($props as $key => $value) {
            $item->$key = strip_tags($value);
        }
        $item->save();
        Image::add($item->id);

        $path = $_SERVER['HTTP_REFERER'];
        header("Location: $path");
    }

    public function actionUpdate()
    {
        if (Sessions::get('user') != 'admin') {
            header("Location: http://shop/");
        }
        $id = (int)$_GET['id'];
        $props = $_POST;
        $product = Product::getOne($id);
        foreach ($props as $key => $value) {
            $product->$key = strip_tags($value);
        }
        $product->save();
        if ($_FILES[Image::$fileArray]['name'][0] !== "") {
            Image::add($id, false);
        }
        $path = $_SERVER['HTTP_REFERER'];
        header("Location: $path");
    }

    public function actionDelete()
    {

        if (Sessions::get('user') != 'admin') {
            return header("Location: http://shop/");
        }
        $id = (int)$_GET['id'];
        $product = Product::getOne($id);
        $product->delete();
        $imgSrc = IMAGES_DIR . $id;
        Image::deleteImgDir($imgSrc);
        while ($image = Image::getOneByProduct($id)) {
            $image->delete();
        }
        $path = $_SERVER['HTTP_REFERER'];
        header("Location: $path");
    }

    public function actionModify()
    {
        $products = Product::getDetailedAll();
        echo $this->render('admin_product_catalog', [
            'title' => 'Редактирование каталога',
            'products' => $products,
            'session' => Sessions::getSessionInfo()
        ]);
    }

    public function actionChange()
    {
        $id = (int)$_GET['id'];
        $product = Product::getDetailedOne($id);
        $images = Image::getAllByProduct($id);
        echo $this->render('product_change', [
            'title' => 'Изменение товара',
            'session' => Sessions::getSessionInfo(),
            'product' => $product,
            'images' => $images
        ]);
    }

    public function actionDeleteImage()
    {
        $id = (int)$_GET['id'];
        $image = Image::getOne($id);
        $image->delete();
        $path = $_SERVER['HTTP_REFERER'];
        header("Location: $path");
    }

    public function actionAvatarImage()
    {
        $imgId = (int)$_GET['imgId'];
        $prodId = (int)$_GET['prodId'];
        if ($oldAvatar = Image::getAvatar($prodId)) {
            $oldAvatar->avatar = 0;
        }
        $newAvatar = Image::getOne($imgId);
        $newAvatar->avatar = 1;
        $oldAvatar->save();
        $newAvatar->save();
        $path = $_SERVER['HTTP_REFERER'];
        header("Location: $path");
    }


}