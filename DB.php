<?php

declare(strict_types=1);

class DB 
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = new PDO("mysql:host=localhost;dbname=todolist", "beko", "9999");
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function SaveUserTodo() 
    {
        if (isset($_POST['input']) && !empty($_POST['input'])) {
            $query = "INSERT INTO list (todo, status) VALUES (:todo, :status)";
            $status = 0;
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':todo', $_POST['input']);
            $stmt->bindParam(':status', $status);
            $stmt->execute();
        }
    }

    public function SendAllUsers() 
    {
        $query = "SELECT * FROM list";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function DeletePlanUser(int $id)
    {
        $query = "DELETE FROM list WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function StrikedUpdate(int $id, bool $number) 
    {
        $status = $number;
        $query = "UPDATE list SET status = :status WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
    }

    public function toggleTodoStatus(int $id) 
    {
        $query = "UPDATE list SET status = NOT status WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function TruncateTodo() 
    {
        $query = "TRUNCATE TABLE list";
        $this->pdo->exec($query);
    }

    public function saveTeleText(string $text)
    {
        $query = "INSERT INTO list (todo) VALUES (:text)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':text', $text);
        $stmt->execute();
    }

    public function sendText(string $text)
    {
        $query = "INSERT INTO todobot (`add`) VALUES (:text)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':text', $text);
        $stmt->execute();
    }

    public function getText()
    {
        $query = "SELECT `add` FROM todobot";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteAddText()
    {
        $query = "DELETE FROM todobot WHERE `add` IS NOT NULL";
        $this->pdo->exec($query);
    }

    public function saveCheck(string $text)
    {
        $query = "INSERT INTO todobot (`check`) VALUES (:text)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':text', $text);
        $stmt->execute();
    }

    public function getCheck()
    {
        $query = "SELECT `check` FROM todobot";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteCheck()
    {
        $query = "DELETE FROM todobot WHERE `check` IS NOT NULL";
        $this->pdo->exec($query);
    }

    public function saveUncheck(string $text)
    {
        $query = "INSERT INTO todobot (`uncheck`) VALUES (:text)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':text', $text);
        $stmt->execute();
    }

    public function getUncheck()
    {
        $query = "SELECT `uncheck` FROM todobot";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteUncheck()
    {
        $query = "DELETE FROM todobot WHERE `uncheck` IS NOT NULL";
        $this->pdo->exec($query);
    }

    public function saveDelete(string $text)
    {
        $query = "INSERT INTO todobot (`delete`) VALUES (:text)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':text', $text);
        $stmt->execute();
    }

    public function getDelete()
    {
        $query = "SELECT `delete` FROM todobot";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteTask()
    {
        $query = "DELETE FROM todobot WHERE `delete` IS NOT NULL";
        $this->pdo->exec($query);
    }

    public function deleteTaskUser(int $id)
    {
        $query = "DELETE FROM list WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function checkTask(int $id)
    {
        $this->StrikedUpdate($id, true);
    }

    public function uncheckTask(int $id)
    {
        $this->StrikedUpdate($id, false);
    }
}
?>
