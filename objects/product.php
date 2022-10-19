<?php

class Product
{
    // подключение к базе данных и имя таблицы
    private $conn;
    private $table_name = "products";

    // свойства объекта
    public $id;
    public $name;
    public $address;
    public $description;
    public $price;
    public $status;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // метод создания товара
    function create()
    {
        // запрос MySQL для вставки записей в таблицу БД «products»
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    name=:name, address=:address, description=:description, price=:price,status=:status";

        $stmt = $this->conn->prepare($query);

        // опубликованные значения
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->status = htmlspecialchars(strip_tags($this->status));

        // привязываем значения
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":status", $this->status);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // метод для получения товаров
    function readAll()
    {
        // запрос MySQL
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY name ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // метод для получения товара
    function readOne()
    {
        // запрос MySQL
        $query = "SELECT
                    name, address, description, price, status
                FROM
                    " . $this->table_name . "
                WHERE
                    id = ?
                LIMIT
                    0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name = $row["name"];
        $this->address = $row["address"];
        $this->description = $row["description"];
        $this->price = $row["price"];
        $this->status = $row["status"];
    }

    // метод для обновления товара
    function update()
    {
        // MySQL запрос для обновления записи (товара)
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    name = :name,
                    address = :address,
                    description = :description,
                    price = :price,
                    status = :status
                WHERE
                    id = :id";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // очистка
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // привязка значений
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":id", $this->id);

        // выполняем запрос
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // метод для удаления товара
    function delete()
    {
        // запрос MySQL для удаления
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        if ($result = $stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}