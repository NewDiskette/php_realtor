<?php

class User
{
    // подключение к базе данных и имя таблицы
    private $conn;
    private $table_name = "users";

    // свойства объекта
    public $id;
    public $username;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function verifyPassword()
    {
        // запрос MySQL: выбираем столбцы в таблице «users»
        $query = "SELECT *
            FROM
                " . $this->table_name . "
            WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['username' => $_POST['username']]);
        if (!$stmt->rowCount()) {
            flash('Пользователь с такими данными не зарегистрирован');
            header('Location: login.php');
            die;
        }
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // проверяем пароль
        if ($_POST['password'] == $user['password']) {
            $_SESSION['user'] = $user['username'];
            flash('Добро пожаловать, ' . $_SESSION['user']);
            header('Location: index.php');
            die;
        }
        flash('Пароль неверен');
        header('Location: login.php');
    }
}
