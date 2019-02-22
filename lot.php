<?php
require_once('functions.php'); //подключаем сценарий с функцией-шаблонизатором
$con= mysqli_init();
mysqli_options($con, MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
mysqli_real_connect($con, "localhost", "root", "", "yeticave_db");
if ($con === false) {
    exit("Ошибка подключения: " . mysqli_connect_error());
}
mysqli_set_charset($con, "utf8");
if (isset($_GET['id'])) {
    $id_lot=intval($_GET['id']);
}
else {
    http_response_code(404);
    header("Location: http:pages/404.html");
    exit();
}
$sql = "SELECT categories.name FROM categories";
$sql_lots = "SELECT title, start_price, image_path, categories.name as category, ifnull(max(rates.sum_price),lots.start_price) as current_price, description FROM lots
JOIN categories ON lots.category_id=categories.id
LEFT JOIN rates ON lots.id=rates.id_lot
WHERE lots.id =$id_lot";
$result = mysqli_query($con, $sql);
$cat = object_in_array($result, $con);
$result_lots = mysqli_query($con, $sql_lots);
$lots=mysqli_fetch_assoc($result_lots);
if (is_null($lots['title'])) {
    header("Location: http:pages/404.html");
    exit();
}
$is_auth = rand(0, 1);
$user_name = 'Лаура'; // укажите здесь ваше имя

$page_content = include_template('lot.php', [
    'categories'=>$cat,
    'lot'=>$lots]);
$layout_content = include_template('layout.php', [
    'title' => 'Yeti - Страница каталога',
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'content' => $page_content,
    'categories' => $cat
]);

print($layout_content);