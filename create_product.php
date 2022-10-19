<?php

// подключим файлы, необходимые для подключения к базе данных и файлы с объектами
include_once "config/database.php";
include_once "objects/product.php";

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// создадим экземпляры класса Product
$product = new Product($db);

// установка заголовка страницы
$page_title = "Создание товара";

require_once "layout_header.php";
?>

<div class="right-button-margin">
    <a href="index.php" class="btn btn-default pull-right">Просмотр всех товаров</a>
</div>

<?php
// если форма была отправлена
if ($_POST): 
    // установим значения свойствам товара
    $product->name = $_POST["name"];
    $product->address = $_POST["address"];
    $product->description = $_POST["description"];
    $product->price = $_POST["price"];
    $product->status = $_POST["status"];

    // создание товара
    if ($product->create()):?>
        <div class="alert alert-success">Товар был успешно создан.</div>
    <!-- если не удается создать товар, сообщим об этом пользователю -->
    <?php else:?>
        <div class="alert alert-danger">Невозможно создать товар.</div>
    <?php endif;
endif;
?>

<!-- HTML-формы для создания товара -->
<form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
  
    <table class="table table-hover table-responsive table-bordered">
  
        <tr>
            <td>Название</td>
            <td><input type="text" name="name" class="form-control" /></td>
        </tr>
  
        <tr>
            <td>Адрес</td>
            <td><input type="text" name="address" class="form-control" /></td>
        </tr>
  
        <tr>
            <td>Описание</td>
            <td><textarea name="description" class="form-control"></textarea></td>
        </tr>

        <tr>
            <td>Цена</td>
            <td><input type="text" name="price" class="form-control" /></td>
        </tr>
        
        <tr>
            <td>Статус</td>
            <td>
                <select class='form-control' name='status' required>
                    <option selected disabled value=''>Выберите статус</option>
                    <option value='актуально'>актуально</option>
                    <option value='не актуально'>не актуально</option>
                </select>
            </td>
        </tr>
       
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Создать</button>
            </td>
        </tr>
  
    </table>
</form>

<?php require_once "layout_footer.php";