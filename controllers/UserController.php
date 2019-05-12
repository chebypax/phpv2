<?php


namespace app\controllers;


use app\models\User;

class UserController extends Controller
{
    public function actionRegister(){
        echo $this->render('register_form', ['title' => 'Регистрация']);
    }
    public function actionCreate(){
        /*var_dump($_POST);

        $a = password_hash('qwerty', PASSWORD_DEFAULT);
        var_dump($a);
        $b = password_verify('qwerty', $a);
        var_dump($b);*/

        $props= $_POST;
        $user = new User();

        foreach ($props as $key=>$value) {
            if($key == 'password'){
                $value = password_hash($value, PASSWORD_DEFAULT);
            }
            $user->$key = $value;
        }
        $user->save();


    }

    public function actionUpdate(){
        $user = new User();
        $props = User::getOne(2);
        foreach ($props as $key=>$value) {
            $user->$key = $value;
        }
        $user->lastname = 'Кашенцев';
        $user->save();
    }

    public function actionDelete(){

        $user = new User();
        $user->id = 3;
        $user->delete();
}
}