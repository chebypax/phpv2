<div id="create-user">
<h2>Регистрация нового пользователя</h2><br>
<form class="registration_form" action="/user/create" method="post" id="registration-form">
    <div class="login-field"><label for="login">
            Логин <br>
            <input type="text" id="login" name="login" placeholder="Логин" required><br>
        </label></div>
    <div><label for="password">
            Пароль <br>
            <input type="password" id="password" name="password" placeholder="Пароль" required> <br>
        </label></div>
    <div><label for="password2">
            Повторите пароль <br>
            <input type="password" name="password2" placeholder="Повторите пароль" required><br>
        </label></div>
    <div><label for="name">
            Имя <br>
            <input type="text" id="name" name="name" placeholder="Имя" required><br>
        </label></div>
    <div><label for="lastname">
            Фамилия <br>
            <input type="text" id="lastname"  name="lastname" placeholder="Фамилия"required> <br>
        </label></div>
    <div><label for="phone">
            Телефон <br>
            <input class="phone_mask" type="text" id="phone" name="phone" placeholder="Телефон"required ><br>
        </label></div>
    <div class="email-field"><label for="email">
            Электронная почта <br>
            <input type="text" id="email" name="email" placeholder="my@google.com" required><br>
        </label></div>
    <div><input type="submit" value="Зарегистрироваться"></div>
</form>
</div>

<script src="/js/validator.js"></script>
