<?php
session_start();

// включаем соединение с БД и файлы с объектами
include_once "config/database.php";
include_once "objects/product.php";

// создаём экземпляры классов БД и объектов
$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

// запрос товаров
$stmt = $product->readAll(); // $from_record_num, $records_per_page
$num = $stmt->rowCount();

// установка заголовка страницы
$page_title = "Вывод товаров";
require_once "layout_header.php";

if (isset($_SESSION['flash'])):?>
    <div class='alert alert-success alert-dismissable'>
        <?= $_SESSION['flash'];?>
    </div>
    <?php unset($_SESSION['flash']);
endif;?>

<div class="right-button-margin">
    <?php if(isset($_SESSION['user'])):?>
        <a href="logout.php" class="btn btn-default pull-right">Выйти</a>
        <?php if($_SESSION['user'] == 'admin'):?>
            <a href="create_product.php" class="btn btn-default pull-right">Добавить товар</a>
        <?php endif;
    else: ?>
        <a href="login.php" class="btn btn-default pull-right">Авторизация</a>
    <?php endif;?>
</div>

<!-- отображаем товары, если они есть -->
<?php if ($num > 0):?>

    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <th>Товар</th>
            <th>Адрес</th>
            <th>Описание</th>
            <th>Цена</th>
            <?php if(isset($_SESSION['user']) and $_SESSION['user'] == 'admin'):?>
                <th>Статус</th>
            <?php endif;?>
            <th>Действия</th>
        </tr>

        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
            extract($row);
            if($status == 'актуально' or (isset($_SESSION['user']) and $_SESSION['user'] == 'admin')):?>
                <tr>
                    <td><?= $name;?></td>
                    <td><?= $address;?></td>
                    <td><?= $description;?></td>
                    <td><?= $price;?></td>
                    <td>
                        <?php if(isset($_SESSION['user']) and $_SESSION['user'] == 'admin') echo $status;?>
                    </td>
                    <td>
                        <!-- ссылки/кнопки для просмотра, редактирования и удаления товара -->
                        <a href='read_product.php?id=<?=$id;?>' class='btn btn-primary left-margin'>
                        <span class='glyphicon glyphicon-list'></span> Просмотр
                        </a>
                        <?php if(isset($_SESSION['user']) and $_SESSION['user'] == 'admin'):?>
                            <a href='update_product.php?id=<?=$id;?>' class='btn btn-info left-margin'>
                            <span class='glyphicon glyphicon-edit'></span> Редактировать
                            </a>

                            <a href='delete_product.php?id=<?=$id;?>' class='btn btn-danger delete-object'>
                            <span class='glyphicon glyphicon-remove'></span> Удалить
                            </a>
                        <?php endif;?>    
                    </td>

                </tr>
            <?php endif;?>
        <?php endwhile;?>
    </table>

<!-- сообщим пользователю, что товаров нет -->
<?php else:?>
    <div class='alert alert-info'>Товары не найдены.</div>
<?php endif;

require_once "layout_footer.php";