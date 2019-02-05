<?php
require_once('functions.php'); //подключаем сценарий с функцией-шаблонизатором
require_once('data.php'); //подключаем сценарий с данными
require_once('price_format.php'); //подключаем сценарий с функцией обрабатывающей строку с ценой
$is_auth = rand(0, 1);
$user_name = 'Лаура'; // укажите здесь ваше имя

$page_content = include_template('index.php', [
    'categories'=>$categories,
    'advertisement'=>$advertisement]);
$layout_content = include_template('layout.php', [
    'title' => 'Yeti - Главная страница',
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'content' => $page_content,
    'categories' => $categories
]);

print($layout_content);
?>


