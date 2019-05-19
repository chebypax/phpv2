<?php


namespace app\controllers;


use app\models\User;
use app\services\Sessions;

class UserController extends Controller
{
    public function actionRegister()
    {
        echo $this->render('register_form', ['title' => 'Регистрация']);
    }

    public function actionCreate()
    {
        $props = $_POST;
        $user = new User();

        foreach ($props as $key => $value) {
            if ($key == 'password') {
                $value = password_hash($value, PASSWORD_DEFAULT);
            }
            $user->$key = strip_tags($value);
        }
        $user->save();


    }

    public function actionUpdate()
    {
        $user = User::getOne(2);
        $user->lastname = 'Кашенцев';
        $user->save();
    }

    public function actionDelete()
    {

        $user = User::getOne(3);
        $user->delete();
    }

    public function actionLogin()
    {
        $login = $_POST['login'];
        $password = $_POST['password'];
        $user = User::getByLogin($login);
        $path = $_SERVER['HTTP_REFERER'];
        if($user && password_verify($password, $user->password)){
            Sessions::set('user', $login);
        }
        header("Location: $path");
    }

    public function actionLogout()
    {
        $path = $_SERVER['HTTP_REFERER'];
        Sessions::set('user', '');
        header("Location: $path");
    }

    public function actionAdmin()
    {
        if (Sessions::get('user') != 'admin'){
            header("Location: http://shop/");
        }
        echo $this->render('admin_panel',[
            'title' => 'Панель администратора',
            'session' => Sessions::getSessionInfo()
        ]);
    }
}