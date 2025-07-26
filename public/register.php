<?php
session_start();

// Initialiser la liste des tâches si elle n'existe pas
if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}

// Ajouter une tâche
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['task'])) {
    $task = htmlspecialchars(trim($_POST['task']));
    if ($task !== '') {
        $_SESSION['tasks'][] = $task;
    }
}

// Supprimer une tâche
if (isset($_GET['delete'])) {
    $index = (int) $_GET['delete'];
    if (isset($_SESSION['tasks'][$index])) {
        array_splice($_SESSION['tasks'], $index, 1);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ma To-Do List</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f5f5f5;
            padding: 40px;
            display: flex;
            justify-content: center;
        }

        .container {
            background: #fff;
            padding: 30px 40px;
            border-radius: 10px;
            width: 400px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            margin-bottom: 20px;
        }

        input[type="text"] {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px 0 0 5px;
        }

        button {
            padding: 10px 15px;
            border: none;
            background-color: #28a745;
            color: white;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
        }

        ul {
            list-style: none;
            padding-left: 0;
        }

        li {
            background: #f0f0f0;
            padding: 10px 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            position: relative;
        }

        li a {
            position: absolute;
            right: 15px;
            top: 10px;
            color: red;
            text-decoration: none;
            font-weight: bold;
        }

        li a:hover {
            color: darkred;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📝 Ma To-Do List</h1>
        <form method="POST">
            <input type="text" name="task" placeholder="Ajouter une tâche...">
            <button type="submit">Ajouter</button>
            
        </form>

        <ul>
            <?php foreach ($_SESSION['tasks'] as $index => $task): ?>
                <li>
                    <?= htmlspecialchars($task) ?>
                    <a href="?delete=<?= $index ?>" title="Supprimer">✖</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
