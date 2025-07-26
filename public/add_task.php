<?php
require_once('../includes/session.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task = htmlspecialchars(trim($_POST['task']));
    $date = htmlspecialchars(trim($_POST['date']));
    $time = htmlspecialchars(trim($_POST['time']));

    if ($task && $date && $time) {
        $_SESSION['tasks'][] = [
            'text' => $task,
            'date' => $date,
            'time' => $time,
            'done' => false
        ];
    }

    header('Location: ../dashboard/dashboard.php');
    exit;
}
?>

<form method="POST" action="add_task.php">
    <input type="text" name="task" placeholder="Entrez votre tâche..." required>
    <label>Date :</label>
    <input type="date" name="date" required>
    <label>Heure :</label>
    <input type="time" name="time" required>
    <button type="submit">Ajouter</button>
</form>
