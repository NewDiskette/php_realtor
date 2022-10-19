<?php
// получаем ID редактируемого товара
$id = isset($_GET["id"]) ? $_GET["id"] : die("ERROR: отсутствует ID.");

// подключаем файлы для работы с базой данных и файлы с объектами
include_once "config/database.php";
include_once "objects/product.php";

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// подготавливаем объекты
$product = new Product($db);

// устанавливаем свойство ID товара для редактирования
$product->id = $id;

// получаем информацию о редактируемом товаре
$product->readOne();

// установка заголовка страницы
$page_title = "Обновление товара";

include_once "layout_header.php";
?>

<div class="right-button-margin">
    <a href="index.php" class="btn btn-default pull-right">Просмотр всех товаров</a>
</div>

<?php
// если форма была отправлена
if ($_POST) {

    // устанавливаем значения свойствам товара
    $product->name = $_POST["name"];
    $product->address = $_POST["address"];
    $product->description = $_POST["description"];
    $product->price = $_POST["price"];
    $product->status = $_POST["status"];

    // обновление товара
    if ($product->update()):?>
        <div class='alert alert-success alert-dismissable'>
            Товар был обновлён
        </div>

    <!-- если не удается обновить товар, сообщим об этом пользователю -->
    <?php else:?>
        <div class='alert alert-danger alert-dismissable'>
            Невозможно обновить товар
        </div>
    <?php endif;
}
?>

<form action="<?= htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post" enctype = "multipart/form-data">
    <table class="table table-hover table-responsive table-bordered">

        <tr>
            <td>Название</td>
            <td><input type="text" name="name" value="<?= $product->name; ?>" class="form-control" /></td>
        </tr>

        <tr>
            <td>Адрес</td>
            <td><input type="text" name="address" value="<?= $product->address; ?>" class="form-control" /></td>
        </tr>

        <tr>
            <td>Описание</td>
            <td><textarea name="description" class="form-control"><?= $product->description; ?></textarea></td>
        </tr>

        <tr>
            <td>Цена</td>
            <td><input type="text" name="price" value="<?= $product->price; ?>" class="form-control" /></td>
        </tr>

        <tr>
            <td>Статус</td>
            <td>
                <?php
                // $stmt = $product->read();

                // помещаем статус в выпадающий список?>
                <select class='form-control' name='status'>
                    <option disabled>Выберите статус</option>
                    <option value='актуально'
                        <?php if($product->status == 'актуально') echo 'selected';?>>
                        актуально
                    </option>
                    <option value='не актуально'
                        <?php if($product->status == 'не актуально') echo 'selected';?>>
                        не актуально
                    </option>
                </select>
                
            </td>
        </tr>

        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Обновить</button>
            </td>
        </tr>

    </table>
</form>

<?php require_once "layout_footer.php";
