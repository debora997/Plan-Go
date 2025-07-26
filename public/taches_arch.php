<?php
require_once('../includes/session.php');
?>

<h2>🗑 Tâches supprimées</h2>
<ul>
    <?php foreach ($_SESSION['deleted_tasks'] as $task): ?>
        <li>
            <?= htmlspecialchars($task['text']) ?><br>
            <small>📅 <?= $task['date'] ?> à <?= $task['time'] ?></small>
        </li>
    <?php endforeach; ?>
</ul>
