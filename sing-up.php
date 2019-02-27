<?php
require_once('functions.php'); //подключаем сценарий с функцией-шаблонизатором
require_once('init.php');

$sql = "SELECT categories.id ,categories.name FROM categories";
$result = mysqli_query($con, $sql);
$cat = object_in_array($result, $con);
$is_auth = rand(0, 1);
$user_name = 'Лаура';
if ($_SERVER['REQUEST_METHOD']=='POST'){
    $user=$_POST;
    $required_fields=['email','password','name','message'];
    $errors=[];
    foreach ($user as $key => $value) {
        if ($key == "email") {
            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $errors[$key] = 'Заполните поле E-mail корректными данными';
            }
        }
    }
    if (isset($_FILES['user-avatar']['name'])){
        $tmp_name=$_FILES['user-avatar']['tmp_name'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $extension=pathinfo($_FILES['user-avatar']['name'],PATHINFO_EXTENSION);
        if($tmp_name!==""){
            $file_type=finfo_file($finfo, $tmp_name);}
        if ($file_type!=="image/png" and $file_type!=="image/jpeg"){
            $errors['user-avatar']='Загрузите картинку в формате jpg, jpeg, png';
        }
        else {
            $tmp_name=uniqid() .".".$extension;
            $user['user-avatar']='img/'.$tmp_name;
        }
    }
    else {
        $errors['user-avatar']='Вы не загрузили файл';
    }
    foreach($required_fields as $key){
        if (empty($_POST[$key])) {
            $errors[$key]='Поле не заполнено';
        }
    }
    if (count($errors)){
        $page_content = include_template('sing-up.php', [
            'categories'=>$cat,
            'user'=>$user,
            'errors' => $errors]);
    }
    else {
        $email=mysqli_real_escape_string($con, $user['email']);
        $sql = "SELECT id FROM users WHERE email = '$email'";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result) > 0) {
            $errors[] = 'Пользователь с этим email уже зарегистрирован';
        }
        else {
            move_uploaded_file($_FILES['user-avatar']['tmp_name'],'img/'.$tmp_name);
            $password = password_hash($user['password'], PASSWORD_DEFAULT);
            $sql = 'INSERT INTO users (name, email, date_registered, password, avatar_path, contact) VALUES ( ?, ?,NOW(), ?, ?, ?)';
            $stmt = db_get_prepare_stmt($con, $sql, [$user['name'], $user['email'], $password, $user['user-avatar'], $user['message']]);
            $result = mysqli_stmt_execute($stmt);
        }
        if ($result && count($errors)) {
            header("Location: login.php");
            exit();
        }
    }
}
else {
    $page_content = include_template('sing-up.php', ['categories'=>$cat]);
}

$layout_content = include_template('layout.php', [
    'title' => 'Yeti - Регистрация',
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'content' => $page_content,
    'categories' => $cat
]);

print($layout_content);

