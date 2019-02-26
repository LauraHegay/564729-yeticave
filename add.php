<?php
require_once('functions.php'); //подключаем сценарий с функцией-шаблонизатором
$con=db_connection();
if ($con === false) {
    exit("Ошибка подключения: " . mysqli_connect_error());
}

$sql = "SELECT categories.id ,categories.name FROM categories";
$result = mysqli_query($con, $sql);
$cat = object_in_array($result, $con);
$is_auth = rand(0, 1);
$user_name = 'Лаура';
if ($_SERVER['REQUEST_METHOD']=='POST'){
    $lot=$_POST;
    $required_fields=['lot-name','category','message','lot-rate','lot-step','lot-date'];
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
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $extension=pathinfo($_FILES['photo2']['name'],PATHINFO_EXTENSION);
        if($tmp_name!==""){
            $file_type=finfo_file($finfo, $tmp_name);}
        if ($file_type!=="image/png" and $file_type!=="image/jpeg"){
            $errors['photo2']='Загрузите картинку в формате jpg, jpeg, png';
        }
        else {
            $tmp_name=uniqid() .".".$extension;
            $lot['photo2']='img/'.$tmp_name;
            move_uploaded_file($_FILES['photo2']['tmp_name'],'img/'.$tmp_name);
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
        $sql = 'INSERT INTO lots (date_create, date_end, title, category_id, start_price, step_rate, image_path, description, user_id) VALUES (NOW(), ?, ?, ?, ?, ?,?, ?,1)';
        $stmt = db_get_prepare_stmt($con, $sql, [$lot['lot-date'],$lot['lot-name'], $lot['category'], $lot['lot-rate'], $lot['lot-step'], $lot['photo2'],$lot['message']]);
        $res = mysqli_stmt_execute($stmt);
        $id_lot = mysqli_insert_id($con);
        header("Location: lot.php?id=$id_lot");
        exit;
    }
}
else {
    $page_content = include_template('add.php', ['categories'=>$cat]);
}

$layout_content = include_template('layout.php', [
    'title' => 'Yeti - Добавление лота',
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'content' => $page_content,
    'categories' => $cat
]);

print($layout_content);

