<?php
require_once('functions.php'); //подключаем сценарий с функцией-шаблонизатором
require_once('init.php');
require_once('getwinner.php');

    $sql_lots = "SELECT lots.id as id_lot, title, start_price, image_path, categories.name, ifnull(max(rates.sum_price),lots.start_price) FROM lots
JOIN categories ON lots.category_id=categories.id
LEFT JOIN rates ON lots.id=rates.id_lot
WHERE lots.date_end >CURRENT_DATE()
group by lots.id
ORDER BY lots.date_create DESC
LIMIT 9";
    $result_lots = mysqli_query($con, $sql_lots);
    $lots=object_in_array($result_lots, $con);

$page_content = include_template('index.php', [
    'categories'=>$cat,
    'advertisements'=>$lots]);
$layout_content = include_template('layout.php', [
    'title' => 'Yeti - Главная страница',
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'content' => $page_content,
    'categories' => $cat
]);

print($layout_content);


