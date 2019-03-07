<?php
require_once('functions.php'); //подключаем сценарий с функцией-шаблонизатором
require_once('init.php');


if (isset($_GET['search'])){
    $search = trim($_GET['search']);
    if ($search) {
        $sql = "SELECT lots.id as id_lot, title, start_price, image_path, categories.name, ifnull(max(rates.sum_price),lots.start_price) FROM lots
    JOIN categories ON lots.category_id=categories.id
    LEFT JOIN rates ON lots.id=rates.id_lot
    WHERE MATCH(title, description) AGAINST(?)
    group by lots.id
    ORDER BY lots.date_create DESC;";

        $stmt = db_get_prepare_stmt($con, $sql, [$search]);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
        if (!empty($lots)){
            $page_content = include_template('search.php', [
                'categories' => $cat,
                'advertisements' => $lots,
                'search'=>$search
            ]);
        } else {
            $message= "Ничего не найдено по вашему запросу";
            $page_content = include_template('search.php', [
                'categories' => $cat,
                'advertisements' => $lots,
                'search'=>$search,
                'message'=>$message
            ]);
        }
    }
}


$layout_content = include_template('layout.php', [
    'title' => 'Yeti - Страница поиска',
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'content' => $page_content,
    'categories' => $cat
]);

print($layout_content);