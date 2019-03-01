<?php
session_start();
$con=db_connection();
if ($con === false) {
    exit("Ошибка подключения: " . mysqli_connect_error());
}
$sql = "SELECT categories.id ,categories.name FROM categories";
$result = mysqli_query($con, $sql);
$cat = object_in_array($result, $con);