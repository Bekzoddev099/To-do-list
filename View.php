<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wrapper">
        <div class="title">
            <h1>Todo List</h1>
        </div>
        <form action="DB.php" method="POST">
            <input type="text" name="input" placeholder="Enter your task">
            <input type="submit" value="Add Task">
        </form>
        <div class="todo-list">
            <ul>
                <?php
                require 'DB.php';
                $db = new DB();
                $tasks = $db->SendAllUsers();
                foreach ($tasks as $task) {
                    $status = $task['status'] == 1 ? 'done' : '';
                    echo "<li class='$status'>{$task['todo']}</li>";
                }
                ?>
            </ul>
        </div>
    </div>
</body>
</html>
