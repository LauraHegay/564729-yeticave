<?php
session_start();
$con=db_connection();
if ($con === false) {
    exit("Ошибка подключения: " . mysqli_connect_error());
}