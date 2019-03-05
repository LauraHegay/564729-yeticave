<?php
require_once('functions.php'); //подключаем сценарий с функцией-шаблонизатором
require_once('init.php');
$show_form=0;


if (isset($_GET['id'])) {
    $id_lot=intval($_GET['id']);
    $sql_lots = "SELECT title, date_end, start_price as sum_price, step_rate,  image_path, categories.name, description, user_id FROM lots
JOIN categories ON lots.category_id=categories.id
WHERE lots.id =$id_lot";
    $result_lots = mysqli_query($con, $sql_lots);
    $lots=mysqli_fetch_assoc($result_lots);
    if ($result_lots->num_rows ===1){
        $sum_lot="SELECT max(rates.sum_price) as sum_price from rates WHERE rates.id_lot=$id_lot";
        $result_sum_lots = mysqli_fetch_assoc(mysqli_query($con, $sum_lot));
        if(is_null($result_sum_lots['sum_price'])){
            $result_sum_lots=['sum_price'=>$lots['sum_price']];
        }
        if($is_auth==1 and $lots['user_id']!=$user_id and strtotime($lots['date_end'])-strtotime('today')>0) {
            $rate="SELECT * FROM rates WHERE rates.id_lot=$id_lot and rates.id_user=$user_id";
            $rate_count = mysqli_num_rows(mysqli_query($con, $rate));
            if ($rate_count==0) {
                $show_form=1;
                if(!empty($_GET['cost'])){
                    $rate=intval($_GET['cost']);
                    if (!filter_var($rate, FILTER_VALIDATE_INT) or $rate<=0 or $rate<(intval($result_sum_lots['sum_price'])+$lots['step_rate'])) {
                        $errors['cost'] = 'Заполните поле "Ваша ставка" корректными данными';
                    }
                    else {
                        $sql = 'INSERT INTO rates (date_registered, sum_price, id_user, id_lot) VALUES (NOW(), ?, ?, ?)';
                        $stmt = db_get_prepare_stmt($con, $sql, [$rate, $user_id, $id_lot]);
                        $result = mysqli_stmt_execute($stmt);
                        if (!$result) {
                            $error = mysqli_error($con);
                            print("Ошибка MySQL: " . $error);
                        }
                    }
                }
                else {
                    $errors['cost'] = 'Поле не заполнено';
                }
            }
        }
        $page_content = include_template('lot.php', [
            'show_form' => $show_form,
            'categories'=>$cat,
            'id_lot'=>$id_lot,
            'lot'=>$lots,
            'sum_price'=>$result_sum_lots,
            'errors'=>$errors
        ]);
    }
    else {
        $page_content = include_template('error.php', [
            'categories' => $cat
        ]);
    }
}
else {
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