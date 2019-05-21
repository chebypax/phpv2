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
        if($user = User::getByLogin($props['login']))
        {
            if($_POST['AJAX'])
            {
                echo json_encode(["status" => 0]);
            } else {
                $path = $_SERVER['HTTP_REFERER'];
                header("Location: $path");
            }
            return;
        }
        if($user = User::getByEmail($props['email']))
        {
            if($_POST['AJAX'])
            {
                echo json_encode(["status" => 1]);
            } else {
                $path = $_SERVER['HTTP_REFERER'];
                header("Location: $path");
            }
            return;
        }
        $user = new User();

        foreach ($props as $key => $value) {
            if ($key == 'password') {
                $value = strip_tags($value);
                $value = password_hash($value, PASSWORD_DEFAULT);
            }
            if ($key == 'phone'){
                $value = strip_tags($value);
                $value = preg_replace("/[^0-9]/", '', $value);
            }
            $user->$key = strip_tags($value);
        }
        $user->save();
        Sessions::set('user', $user->login);

            if($_POST['AJAX'])
            {
                echo json_encode(["status" => 2, 'user' => $user] );
            } else {
                $path = $_SERVER['HTTP_REFERER'];
                header("Location: $path");
            }
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