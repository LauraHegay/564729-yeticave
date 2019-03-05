<?php
require_once('functions.php'); //подключаем сценарий с функцией-шаблонизатором
require_once('init.php');
session_destroy();
header("Location: /index.php");
