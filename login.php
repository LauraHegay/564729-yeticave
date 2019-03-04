<?php
require_once('functions.php'); //подключаем сценарий с функцией-шаблонизатором
require_once('init.php');

if ($_SERVER['REQUEST_METHOD']=='POST') {
    $form = $_POST;
    $required_fields = ['email', 'password'];
    $errors = [];

    if (isset($form['email'])) {
        if (!filter_var($form['email'], FILTER_VALIDATE_EMAIL)){
            $errors['email'] = 'Заполните поле E-mail корректными данными';
        }else {
            $errors['email'] = 'Поле не заполнено';
        }
    }
    if (!isset($form['password'])) {
        $errors['password'] = 'Поле не заполнено';
    }
    if (count($errors)) {
        $page_content = include_template('login.php', [
            'categories' => $cat,
            'user' => $form,
            'errors' => $errors]);
    } else {
        $email = mysqli_real_escape_string($con, $form['email']);
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($con, $sql);
        if ($result) {
            $user=mysqli_fetch_array($result, MYSQLI_ASSOC);
            if (password_verify($form['password'], $user['password'])) {
                $_SESSION['user'] = $user;
                header("Location: index.php");
                exit();
            } else {
                $errors['password'] = 'Неверный пароль или пользователя с таким e-mail не существует';
                $page_content = include_template('login.php', ['form' => $form, 'categories'=>$cat, 'errors' => $errors]);
            }
        } else {
            $errors['email'] = 'Ошибка при получении записи из базы данных';
            $page_content = include_template('login.php', ['form' => $form, 'categories'=>$cat, 'errors' => $errors]);
        }
    }
}
else {
    $page_content = include_template('login.php', ['categories'=>$cat]);
}

$layout_content = include_template('layout.php', [
    'title' => 'Yeti - Авторизация',
    'content' => $page_content,
    'categories' => $cat
]);

print($layout_content);