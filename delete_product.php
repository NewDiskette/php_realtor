<?php

// проверим, было ли получено значение в $_GET
if ($_GET) {

    // подключаем файлы для работы с базой данных и файлы с объектами
    include_once "config/database.php";
    include_once "objects/product.php";

    // получаем соединение с базой данных
    $database = new Database();
    $db = $database->getConnection();

    // подготавливаем объект Product
    $product = new Product($db);

    // устанавливаем ID товара для удаления
    $product->id = $_GET["id"];

    // удаляем товар
    if ($product->delete()) {
        header('Location: index.php');
    }

    // если невозможно удалить товар
    else {
        echo "Невозможно удалить товар";
    }
}
