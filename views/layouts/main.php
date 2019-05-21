<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $params['title'] ?></title>
    <link rel="stylesheet" href="/css/style.css" type="text/css" media="all">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
          integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>
</head>
<body>

<div class="header">Это хедер</div>

<div class="header-fields">
<?php if(!$params['session']['user']):?>
    <p><a class="header" href="/user/register">Регистрация</a></p>
    <form action='/user/login' method='post'>
        <input type='text' name='login' placeholder='Логин' required>
        <input type='password' name='password' placeholder='Пароль' required>
        <input type='submit' value='Войти'>
    </form>
<?php elseif ($params['session']['user'] == 'admin'):?>
    <p><a href='/user/admin'>Панель администратора</a></p>
    <p><a href='/user/logout'>Сменить пользователя (<?=$params['session']['user']?>)</a></p>
<?php else :?>
    <a href='/user/logout'>Сменить пользователя (<?=$params['session']['user']?>)</a>
<?php endif;?>
</div>

<p><a href="/">На главную</a>
<a href='/order/cart'>Корзина(<span id="cart-quantity"><?=$params['session']['quantity']?></span>)</a></p>

<div class="content"><?= $content ?></div>

<div class="footer">Это футер</div>


<script src="/js/jquery.maskedinput.min.js"></script>
<script src="/js/main.js"></script>
</body>
</html>
