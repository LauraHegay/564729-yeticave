<?php
require_once('functions.php'); //подключаем сценарий с функцией-шаблонизатором
require_once('init.php');
unset($_SESSION['user']);
header("Location: /index.php");
