<?php
require_once('functions.php'); //подключаем сценарий с функцией-шаблонизатором
require_once('init.php');
$show_form=0;

if (isset($_GET['id'])) {
    $id_lot=intval($_GET['id']);
    $sql_lots = "SELECT title, date_end, start_price as sum_price, image_path, categories.name, description, user_id FROM lots
JOIN categories ON lots.category_id=categories.id
WHERE lots.id =$id_lot";
    $result_lots = mysqli_query($con, $sql_lots);
    $lots=mysqli_fetch_assoc($result_lots);
    if ($result_lots->num_rows ===1){
        $sum_lot="SELECT max(rates.sum_price) as sum_price from rates
WHERE rates.id_lot=$id_lot";
        $result_sum_lots = mysqli_fetch_assoc(mysqli_query($con, $sum_lot));
        if(is_null($result_sum_lots['sum_price'])){
            $result_sum_lots=['sum_price'=>$lots['sum_price']];
        }
        if($is_auth==1 and $lots['user_id']!=$user_id) {
            $show_form=1;
        }
        $page_content = include_template('lot.php', [
            'show_form' => $show_form,
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

var_dump($show_form);

$layout_content = include_template('layout.php', [
    'title' => 'Yeti - Страница каталога',
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'content' => $page_content,
    'categories' => $cat
]);

print($layout_content);