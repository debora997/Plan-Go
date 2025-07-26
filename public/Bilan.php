<?php
// Connexion BDD
$pdo = new PDO('mysql:host=localhost;dbname=todo_db;charset=utf8', 'root', '');

// Affichage erreurs
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Récupération des tâches complétées aujourd’hui
$today = date('Y-m-d');
$sql = "SELECT * FROM tasks WHERE completed = 1 AND DATE(completed_at) = :today";
$stmt = $pdo->prepare($sql);
$stmt->execute(['today' => $today]);
$completedTasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
$totalToday = count($completedTasks);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>To Do - Bilan</title>
    <style>
        body { font-family: Arial; background-color: #f0f0f0; text-align: center; padding: 40px; }

        button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }

        /* POP-UP MODAL */
        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 20px;
            width: 50%;
            border-radius: 10px;
            text-align: left;
        }

        .close {
            color: red;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .task { margin: 5px 0; border-left: 5px solid green; padding: 5px; }
    </style>
</head>
<body>

    <h1>Ma To Do List</h1>

    <button onclick="openModal()">Voir le bilan de la journée</button>

    <!-- Le Pop-up -->
    <div id="bilanModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Bilan du <?php echo date('d/m/Y'); ?></h2>

            <?php if ($totalToday > 0): ?>
                <p><strong><?= $totalToday ?></strong> tâche<?= $totalToday > 1 ? 's' : '' ?> complétée<?= $totalToday > 1 ? 's' : '' ?> aujourd’hui 🎉</p>
                <?php foreach ($completedTasks as $task): ?>
                    <div class="task"><?= htmlspecialchars($task['title']) ?></div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucune tâche complétée aujourd’hui. Courage pour demain 💪</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById("bilanModal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("bilanModal").style.display = "none";
        }

        // Ferme le modal si on clique à l’extérieur
        window.onclick = function(event) {
            const modal = document.getElementById("bilanModal");
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>
