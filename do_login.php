<?php

// Инициализируем сессию
session_start();

var_dump($_SESSION);

// включаем соединение с БД и файлы с объектами
include_once "config/database.php";
include_once "objects/user.php";
include_once "flash.php";

// создаём экземпляр класса БД
$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$stmt = $user->verifyPassword();


