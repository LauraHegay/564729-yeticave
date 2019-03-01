<?php
require_once('functions.php'); //подключаем сценарий с функцией-шаблонизатором
require_once('init.php');

if ($_SERVER['REQUEST_METHOD']=='POST') {
    $form = $_POST;
    $required_fields = ['email', 'password'];
    $errors = [];
    if (!isset($form['email']) || !filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Заполните поле E-mail корректными данными';
    }
    foreach ($required_fields as $key) {
        if (empty($_POST[$key])) {
            $errors[$key] = 'Поле не заполнено';
        }
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
        $user = $result ? mysqli_fetch_array($result, MYSQLI_ASSOC) : null;
        if ($user) {
            if (password_verify($form['password'], $user['password'])) {
                $_SESSION['user'] = $user;
                header("Location: index.php");
                exit();
            } else {
                $errors['password'] = 'Неверный пароль';
                $page_content = include_template('login.php', ['form' => $form, 'categories'=>$cat, 'errors' => $errors]);
            }
        } else {
            $errors['email'] = 'Такой пользователь не найден';
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