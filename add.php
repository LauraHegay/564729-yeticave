<?php
require_once('functions.php'); //подключаем сценарий с функцией-шаблонизатором
$con= mysqli_init();
mysqli_options($con, MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
mysqli_real_connect($con, "localhost", "root", "", "yeticave_db");
if ($con === false) {
    exit("Ошибка подключения: " . mysqli_connect_error());
}
mysqli_set_charset($con, "utf8");
$sql = "SELECT categories.id ,categories.name FROM categories";
$result = mysqli_query($con, $sql);
$cat = object_in_array($result, $con);
$is_auth = rand(0, 1);
$user_name = 'Лаура';
if ($_SERVER['REQUEST_METHOD']=='POST'){
    $lot=$_POST;
    $required_fields=['lot-name','category','message','lot-rate','lot-step','lot-date'];
    $dict = ['lot-name' => 'Название',
             'category' => 'Категория',
             'message' => 'Описание',
             'photo2' => 'Изображение',
             'lot-rate' => 'Ставка',
             'lot-step' => 'Шаг ставки',
             'lot-date' => 'Дата создания'];
    $errors=[];
    foreach ($lot as $key => $value){
        if ($key=="lot-rate"){
            if(!filter_var($value,FILTER_VALIDATE_INT)){
                $errors[$key]='Заполните поле Ставка корректными данными';
            }
        }
        elseif ($key=="lot-step"){
            if(!filter_var($value,FILTER_VALIDATE_INT)){
                $errors[$key]='Заполните поле Шаг ставки корректными данными';
            }
        }
    }
    if (isset($_FILES['photo2']['name'])){
        $tmp_name=$_FILES['photo2']['tmp_name'];
        $path=$_FILES['photo2']['name'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        if($tmp_name!==""){
            $file_type=finfo_file($finfo, $tmp_name);}
        if ($file_type!=="image/png" and $file_type!=="image/jpeg"){
            $errors['photo2']='Загрузите картинку в формате jpg, jpeg, png';
        }
        else {
            move_uploaded_file($tmp_name,'img/'.$path);
            $lot['photo2']='img/'.$path;
        }
    }
    else {
        $errors['photo2']='Вы не загрузили файл';
    }
    foreach($required_fields as $key){
        if (empty($_POST[$key])) {
            $errors[$key]='Поле не заполнено';
        }
    }
    if (count($errors)){
        $page_content = include_template('add.php', [
            'categories'=>$cat,
            'lot'=>$lot,
            'errors' => $errors,
            'dict' => $dict]);
    }
    else {
        $sql = 'INSERT INTO lots (date_create, date_end, title, category_id, start_price, step_rate, image_path, user_id) VALUES (NOW(), ?, ?, ?, ?, ?, ?,1)';

        $stmt = db_get_prepare_stmt($con, $sql, [$lot['lot-date'],$lot['lot-name'], $lot['category'], $lot['lot-rate'], $lot['lot-step'], $lot['photo2']]);
        $res = mysqli_stmt_execute($stmt);
        $id_lot = mysqli_insert_id($con);
        //$url="Location: lot.php?id=$id_lot";
        header("Location: lot.php?id=$id_lot");
    }
}
else {
    $page_content = include_template('add.php', ['categories'=>$cat]);
}


/*

$page_content = include_template('add.php', [
    'categories'=>$cat,
    'lot'=>$lots,
    'sum_price'=>$result_sum_lots]);
*/

$layout_content = include_template('layout.php', [
    'title' => 'Yeti - Добавление лота',
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'content' => $page_content,
    'categories' => $cat
]);

print($layout_content);

