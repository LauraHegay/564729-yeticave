<?php
require_once('functions.php'); //подключаем сценарий с функцией-шаблонизатором
$is_auth = rand(0, 1);
$user_name = 'Лаура'; // укажите здесь ваше имя
$con= mysqli_init();
mysqli_options($con, MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
mysqli_real_connect($con, "localhost", "root", "", "yeticave_db");
if ($con === false) {
    exit("Ошибка подключения: " . mysqli_connect_error());
}
mysqli_set_charset($con, "utf8");
$sql = "SELECT categories.name FROM categories";
$result = mysqli_query($con, $sql);
$cat = object_in_array($result, $con);
if (isset($_GET['id'])) {
    $id_lot=intval($_GET['id']);
    $sql_lots = "SELECT title, start_price as sum_price, image_path, categories.name FROM lots
JOIN categories ON lots.category_id=categories.id
WHERE lots.id =$id_lot";
    $result_lots = mysqli_query($con, $sql_lots);
    $lots=mysqli_fetch_assoc($result_lots);
    var_dump($result_lots->num_rows ===1);
    if ($result_lots->num_rows ===1){

        $sum_lot="SELECT max(rates.sum_price) as sum_price from rates
WHERE rates.id_lot=$id_lot";
        $result_sum_lots = mysqli_fetch_assoc(mysqli_query($con, $sum_lot));
        if(is_null($result_sum_lots['sum_price'])){
            $result_sum_lots=['sum_price'=>$lots['sum_price']];
        }
        $page_content = include_template('lot.php', [
            'categories'=>$cat,
            'lot'=>$lots,
            'sum_price'=>$result_sum_lots]);
    } else {
        $page_content = include_template('error.php', [
            'categories' => $cat
        ]);
    }
} else {
    $page_content = include_template('error.php', [
        'categories' => $cat
    ]);
}

$layout_content = include_template('layout.php', [
    'title' => 'Yeti - Страница каталога',
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'content' => $page_content,
    'categories' => $cat
]);

print($layout_content);