<?php
require_once('functions.php'); //подключаем сценарий с функцией-шаблонизатором
require_once('data.php'); //подключаем сценарий с данными
$con= mysqli_init();
mysqli_options($con, MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
mysqli_real_connect($con, "localhost", "root", "", "yeticave_db");
if ($con == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
}
else {
    mysqli_set_charset($con, "utf8");
    $sql = "SELECT categories.name FROM categories";
    $sql_lots = "SELECT title, start_price, image_path, categories.name, ifnull(max(rates.sum_price),lots.start_price) FROM lots
JOIN categories ON lots.category_id=categories.id
LEFT JOIN rates ON lots.id=rates.id_lot
WHERE lots.date_end >CURRENT_DATE()
group by lots.id
ORDER BY lots.date_create DESC
LIMIT 9";
    $result = mysqli_query($con, $sql);
    $result_lots = mysqli_query($con, $sql_lots);
    if (!$result || !$result_lots) {
        $error = mysqli_error($con);
        print("Ошибка MySQL: " . $error);
    }
    $cat = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $lots=mysqli_fetch_all($result_lots, MYSQLI_ASSOC);
}
$is_auth = rand(0, 1);
$user_name = 'Лаура'; // укажите здесь ваше имя

$page_content = include_template('index.php', [
    'categories'=>$categories,
    'advertisements'=>$lots]);
$layout_content = include_template('layout.php', [
    'title' => 'Yeti - Главная страница',
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'content' => $page_content,
    'categories' => $cat
]);

print($layout_content);


