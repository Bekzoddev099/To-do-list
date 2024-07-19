<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .completed {
            text-decoration: line-through;
        }
        .large-checkbox {
            width: 35px;
            height: 35px;
        }
        .checkbox {
            width: 20px;
            height: 20px;
        }
        .delete-icon {
            color: red;
            cursor: pointer;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3>To-Do List</h3>
            </div>
            <div class="card-body">
                <form action="index.php" method="post" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="input" class="form-control" placeholder="Things to do">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </div>
                </form>
                <div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Plan</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($currentItems as $userInfo): ?>
                                <tr>
                                    <td class="<?php echo $userInfo['status'] ? 'completed' : ''; ?>">
                                        <?php echo htmlspecialchars($userInfo['todo']); ?>
                                    </td>
                                    <td>
                                        <form action="index.php" method="post">
                                            <input type="hidden" name="id" value="<?php echo $userInfo['id']; ?>">
                                            <input type="checkbox" class="checkbox" 
                                                   onChange="this.form.submit()" 
                                                   <?php if ($userInfo['status']) echo 'checked'; ?>>
                                        </form>
                                    </td>
                                    <td>
                                        <a href="index.php?id=<?php echo $userInfo['id']; ?>" class="delete-icon"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-between align-items-center">
                        <form action="index.php" method="post">
                            <button type="submit" class="btn btn-primary" name="truncateButton">Delete all</button>
                        </form>

                        <nav aria-label="Page navigation example">
                            <ul class="pagination mb-0">
                                <li class="page-item <?php if($PageCurrent <= 1) echo 'disabled'; ?>">
                                    <a class="page-link" href="<?php if($PageCurrent > 1) echo '?page='.($PageCurrent - 1); else echo '#'; ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php for ($i = 1; $i <= $pagesTotal; $i++): ?>
                                    <li class="page-item <?php if($i == $PageCurrent) echo 'active'; ?>">
                                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>
                                <li class="page-item <?php if($PageCurrent >= $pagesTotal) echo 'disabled'; ?>">
                                    <a class="page-link" href="<?php if($PageCurrent < $pagesTotal) echo '?page='.($PageCurrent + 1); else echo '#'; ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
