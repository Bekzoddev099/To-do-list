<?php

declare(strict_types=1);

class DB
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = new PDO("mysql:host=localhost;dbname=todolist", "beko", "9999");
    }

    public function SaveDotolist()
    {
        if (isset($_POST['input']) && !empty($_POST['input'])) {
            $query = "INSERT INTO list (todo, status) VALUES (:todo, :status)";
            $status = 0;
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':todo', $_POST['input']);
            $stmt->bindParam(':status', $status, PDO::PARAM_INT);
            $stmt->execute();
        }
    }

    public function SendTodo()
    {
        $query = "SELECT * FROM list";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function DeleteList(int $id)
    {
        $query = "DELETE FROM list WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function StrikedUpdate(int $id, bool $number)
    {
        $status = $number ? 1 : 0;
        $query = "UPDATE list SET status = :status WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function toggleStatus($id)
    {
        $stmt = $this->pdo->prepare('SELECT status FROM list WHERE id = ?');
        $stmt->execute([$id]);
        $todo = $stmt->fetch();
        $newStatus = $todo['status'] ? 0 : 1;
        $stmt = $this->pdo->prepare('UPDATE list SET status = ? WHERE id = ?');
        $stmt->execute([$newStatus, $id]);
    }

    public function TrancateList()
    {
        $query = "TRUNCATE TABLE list";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
    }
}
