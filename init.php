<?php
session_start();
$is_auth=0;

if (isset($_SESSION['user'])){
    $is_auth=1;
    $user_name = $_SESSION['user']['name'];
    $user_id = $_SESSION['user']['id'];
}

$con=db_connection();
if ($con === false) {
    exit("Ошибка подключения: " . mysqli_connect_error());
}
$sql = "SELECT categories.id ,categories.name FROM categories";
$result = mysqli_query($con, $sql);
$cat = object_in_array($result, $con);