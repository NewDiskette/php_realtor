<?php
session_start();
// получаем ID товара
$id = isset($_GET["id"]) ? $_GET["id"] : die("ERROR: отсутствует ID.");

// подключаем файлы для работы с базой данных и файлы с объектами
include_once "config/database.php";
include_once "objects/product.php";

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();
 
// подготавливаем объекты
$product = new Product($db);

// устанавливаем свойство ID товара для чтения
$product->id = $id;

// получаем информацию о товаре
$product->readOne();

// установка заголовка страницы
$page_title = "Страница товара (чтение одного товара)";

require_once "layout_header.php";
?>

<!-- ссылка на все товары -->
<div class="right-button-margin">
    <a href="index.php" class="btn btn-primary pull-right">
        <span class="glyphicon glyphicon-list"></span> Просмотр всех товаров
    </a>
</div>

<!-- HTML-таблица для отображения информации о товаре -->
<table class="table table-hover table-responsive table-bordered">
    <tr>
        <td>Название</td>
        <td><?= $product->name; ?></td>
    </tr>
    <tr>
        <td>Адрес</td>
        <td><?= $product->address; ?></td>
    </tr>
    <tr>
        <td>Описание</td>
        <td><?= $product->description; ?></td>
    </tr>
    <tr>
        <td>Цена</td>
        <td><?= $product->price; ?></td>
    </tr>
    <?php if(isset($_SESSION['user']) and $_SESSION['user'] == 'admin'):?>
        <tr>
            <td>Статус</td>
            <td><?= $product->status; ?></td>
        </tr>
    <?php endif;?>
</table>

<?php require_once "layout_footer.php";