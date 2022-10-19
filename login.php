<?php
session_start();

// установка заголовка страницы
$page_title = "Авторизация";

require_once "layout_header.php";

if(isset($_SESSION['flash'])):?> 
    <div class='alert alert-danger alert-dismissable'>
        <?= $_SESSION['flash'];?>
    </div>
<?php endif;?>

<form method="post" action="do_login.php">
    <div class="mb-3">
        <label for="username" class="form-label">Логин</label>
        <input type="text" class="form-control" id="username" name="username" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Пароль</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <div class="d-flex justify-content-between">
        <button type="submit" class="btn btn-primary">Авторизация</button>
    </div>
</form>

