<?php
session_start();

// Initialisation
$allTasks = $_SESSION['tasks'] ?? [];
$deletedTasks = $_SESSION['deleted_tasks'] ?? [];

$total = 0;
$done = 0;

foreach ($allTasks as $task) {
    if (!empty($task['done'])) {
        $done++;
    } else {
        $total++;
    }
}

$archived = count($deletedTasks);
$totalOfDay = $total + $done + $archived;

// Ajouter une tâche
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task'], $_POST['date'], $_POST['time'])) {
    $task = htmlspecialchars(trim($_POST['task']));
    $date = htmlspecialchars(trim($_POST['date']));
    $time = htmlspecialchars(trim($_POST['time']));

    $_SESSION['tasks'][] = [
        'text' => $task,
        'date' => $date,
        'time' => $time,
        'done' => false,
        'delete' => false
    ];

    header("Location: dashboard.php");
    exit;
}

// Marquer comme terminée
if (isset($_GET['done'])) {
    $i = (int) $_GET['done'];
    if (isset($_SESSION['tasks'][$i])) {
        $_SESSION['tasks'][$i]['done'] = true;
    }
    header("Location: dashboard.php");
    exit;
}

// Archiver une tâche
if (isset($_GET['delete'])) {
    $i = (int) $_GET['delete'];
    if (isset($_SESSION['tasks'][$i])) {
        $_SESSION['deleted_tasks'][] = $_SESSION['tasks'][$i];
        unset($_SESSION['tasks'][$i]);
        $_SESSION['tasks'] = array_values($_SESSION['tasks']); // Réindexer
    }
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - To Do</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f1f1f1;
        }

        .dashboard {
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #74ebd5, #ACB6E5);
            color: white;
            padding: 20px;
        }

        .sidebar h2 {
            margin-bottom: 30px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar li {
            margin-bottom: 20px;
        }

        .sidebar a {
            color: black;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
        }

        .main {
            flex: 1;
            padding: 40px;
        }

        .hero-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .hero-text {
            max-width: 50%;
        }

        .hero-text h1 {
            font-size: 28px;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .hero-text p {
            font-size: 16px;
            color: #555;
        }

        .hero-image img {
            width: 350px;
            max-width: 100%;
            border-radius: 10px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 10;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fff;
            margin: 8% auto;
            padding: 30px;
            border-radius: 10px;
            width: 400px;
            position: relative;
        }

        .close {
            position: absolute;
            right: 15px;
            top: 10px;
            font-size: 20px;
            color: #aaa;
            cursor: pointer;
        }

        .close:hover {
            color: #000;
        }

        input[type="text"], input[type="date"], input[type="time"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
        }

        button {
            padding: 10px 15px;
            background: #28a745;
            color: white;
            border: none;
        }

        ul {
            list-style: none;
            padding-left: 0;
        }

        li {
            background: #eee;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
        }

        .done {
            text-decoration: line-through;
            color: gray;
        }

        .action-links a {
            margin-left: 10px;
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
        }

        .action-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="dashboard">
    <div class="sidebar">
        <h2>📋 Menu</h2>
        <ul>
            <li><a onclick="openModal('addModal')">➕ Ajouter une tâche</a></li>
            <li><a onclick="openModal('boxModal')">📦 Boîte à tâches</a></li>
            <li><a onclick="openModal('terminModal')">✔️ Tâches terminées</a></li>
            <li><a onclick="openModal('archivModal')">🗃️ Tâches Archivées</a></li>
            <li><a onclick="openModal('bilanModal')">📊 Bilan de la journée</a></li>
<!-- Bouton Déconnexion -->
<button onclick="openLogoutModal()" style="background-color: #e74c3c; color: white; padding: 10px; border: none; border-radius: 5px; width: 100%; margin-top: 10px;">
  🔒 Déconnexion
</button>
        </ul>
        <!-- 🗓️ Mini calendrier -->
<div class="calendar-section" style="padding: 15px; border-top: 1px solid #ccc;">
  <h4>📅 Planifier une tâche</h4>
  <input type="date" id="calendar-date" min="<?= date('Y-m-d') ?>" onchange="openTaskModal()" style="padding: 6px; margin-top: 10px; width: 100%;">
</div>

<!-- 💬 MODAL pour créer une tâche -->
<div id="taskModal" class="modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:999;">
  <div style="background:#fff; max-width:400px; margin:100px auto; padding:20px; border-radius:10px; position:relative;">
            <h2 style="color:black">Créer une nouvelle tâche</h2>
    <form method="POST" action="ajouter_tache.php">
      <input type="hidden" name="date" id="selectedDate">

        <label for="title" style="color:black">Titre :</label>
      <input type="text" name="title" required style="width:100%; padding:5px; margin-bottom:10px;">

      <label for="priority" style="color:black">Priorité :</label>
      <select name="priority" style="width:100%; padding:5px; margin-bottom:10px;">
        <option value="Haute">Haute</option>
        <option value="Moyenne">Moyenne</option>
        <option value="Basse">Basse</option>
      </select>

      <label for="note" style="color:black">Note :</label>
      <textarea name="note" rows="3" style="width:100%; padding:5px; margin-bottom:10px;"></textarea>
      <label for="color" style="color:black">Couleur :</label>

      <input type="color" name="color" value="#00bfff" style="width:100%; height:35px; margin-bottom:10px;">

      <button type="submit" style="padding:8px 15px; background-color:green; color:white; border:none;">✅ Enregistrer</button>
      <button type="button" onclick="closeTaskModal()" style="padding:8px 15px; background-color:gray; color:white; border:none; margin-left:10px;">❌ Annuler</button>
    </form>
    <!-- 🔍 Zone d'affichage des tâches -->
<div id="taskDisplay" style="padding: 15px; display: none; background:rgb(241, 238, 238); border-radius: 10px; margin-top: 10px;"></div>
  </div>
</div>
    </div>

    
    <div class="main">
        <div class="hero-content">
            <div class="hero-text">
                <h1>🎯 Atteins tes objectifs du jour</h1>
                <p>Organise ta journée, avance pas à pas, et célèbre chaque tâche accomplie.</p>
            </div>
            <div class="hero-image">
                <img src="plan_go.png" alt="Dashboard inspiration">
            </div>
        </div>
    </div>
</div>

<!-- Modal Ajouter une tâche -->
<div id="addModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('addModal')">&times;</span>
        <h3>Ajouter une nouvelle tâche</h3>
        <form method="POST">
            <input type="text" name="task" placeholder="Entrez votre tâche..." required>
            <label>Date d'échéance :</label>
            <input type="date" name="date" required>
            <label>Heure :</label>
            <input type="time" name="time" required>
            <button type="submit">Ajouter</button>
        </form>
    </div>
</div>

<!-- Modal Boîte à tâches -->
<div id="boxModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('boxModal')">&times;</span>
        <h3>📦 Mes tâches</h3>
        <ul>
            <?php if (!empty($_SESSION['tasks'])): ?>
                <?php foreach ($_SESSION['tasks'] as $index => $task): ?>
                    <?php
                        // Sécurité : on s'assure que les clés existent
                        $text = $task['text'] ?? '[Tâche inconnue]';
                        $date = $task['date'] ?? 'Inconnue';
                        $time = $task['time'] ?? 'Inconnue';
                        $done = !empty($task['done']);
                    ?>
                    <li class="<?= $done ? 'done' : '' ?>">
                        <?= htmlspecialchars($text) ?><br>
                        <small>📅 Échéance : <?= htmlspecialchars($date) ?> à <?= htmlspecialchars($time) ?></small>
                        <div class="action-links">
                            <?php if (!$done): ?>
                                <a href="?done=<?= $index ?>">✔ Terminer</a>
                            <?php endif; ?>
                            <a href="?delete=<?= $index ?>">🗑 Archiver</a>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>Aucune tâche pour le moment.</li>
            <?php endif; ?>
        </ul>
    </div>
</div>


<!-- Modal tâches terminées -->
<div id="terminModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('terminModal')">&times;</span>
        <h3>📦 Mes tâches terminées</h3>
        <ul>
            <?php
            $doneTasks = array_filter($_SESSION['tasks'], fn($task) => !empty($task['done']));
            if (count($doneTasks) > 0):
                foreach ($doneTasks as $task):
            ?>
                <li class="done">
                    <?= htmlspecialchars($task['text']) ?><br>
                    <small>📅 Échéance : <?= htmlspecialchars($task['date']) ?> à <?= htmlspecialchars($task['time']) ?></small>
                </li>
            <?php endforeach; ?>
            <?php else: ?>
                <li>Aucune tâche terminée pour l’instant.</li>
            <?php endif; ?>
        </ul>
    </div>
</div>

<!-- Modal tâches archivées -->
<div id="archivModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('archivModal')">&times;</span>
        <h3>🗃️ Tâches archivées</h3>
        <?php if (count($deletedTasks) > 0): ?>
            <ul>
                <?php foreach ($deletedTasks as $task): ?>
                    <li>
                        <?= htmlspecialchars($task['text'] ?? '[Tâche inconnue]') ?><br>
                        <small>📅 Échéance : <?= htmlspecialchars($task['date'] ?? 'Inconnue') ?> à <?= htmlspecialchars($task['time'] ?? 'Inconnue') ?></small>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Aucune tâche archivée pour l’instant 📭</p>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Bilan -->
<div id="bilanModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('bilanModal')">&times;</span>
        <h3>📊 Bilan de la journée</h3>
        <ul>
            <li>📝 Tâches créées aujourd’hui : <strong><?= $totalOfDay ?></strong></li>
            <li>✅ Tâches terminées : <strong><?= $done ?></strong></li>
            <li>📁 Tâches archivées : <strong><?= $archived ?></strong></li>
            <li>📌 Tâches à faire : <strong><?= $total ?></strong></li>
        </ul>
        <?php if ($done > 0): ?>
            <p>👏 Bravo, tu avances bien aujourd’hui ! 💪</p>
        <?php else: ?>
            <p>💡 Allez, il est temps de commencer !</p>
        <?php endif; ?>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(id).style.display = "block";
    }

    function closeModal(id) {
        document.getElementById(id).style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = "none";
        }
    }
</script>

<!-- Modal de Déconnexion -->
<div id="logoutModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:9999;">
  <div style="background:white; width:90%; max-width:400px; margin:10% auto; padding:20px; border-radius:10px; text-align:center;">
    <h3>🔔 Voulez-vous vraiment quitter Plan&Go ?</h3>
    
    <div id="logoutChoices">
      <button onclick="confirmLogoutModal()" style="margin:10px; padding:10px 20px; background-color:#3498db; color:white; border:none; border-radius:5px;">Confirmer</button>
      <button onclick="closeLogoutModal()" style="margin:10px; padding:10px 20px; background-color:gray; color:white; border:none; border-radius:5px;">Annuler</button>
    </div>

    <div id="logoutOptions" style="display:none; margin-top:15px;">
      <p>Pourquoi partez-vous ?</p>
      <button onclick="handleLogoutReason('pause')" style="margin:5px; padding:8px 15px; background:#f1c40f; border:none; border-radius:5px;">🔄 Je veux faire une pause</button>
      <button onclick="handleLogoutReason('dislike')" style="margin:5px; padding:8px 15px; background:#e67e22; border:none; border-radius:5px;">😕 Je n’ai pas aimé l’appli</button>
        <button onclick="showEmailConfirm('confused')" style="margin:5px; padding:8px 15px; background:#e67e22; border:none; border-radius:5px;">🤯 Je suis perdu(e)</button>
    </div>


<script>
  function openLogoutModal() {
    document.getElementById("logoutModal").style.display = "block";
    document.getElementById("logoutChoices").style.display = "block";
    document.getElementById("logoutOptions").style.display = "none";
  }

  function closeLogoutModal() {
    document.getElementById("logoutModal").style.display = "none";
  }

  function confirmLogoutModal() {
    // Afficher les options après confirmation
    document.getElementById("logoutChoices").style.display = "none";
    document.getElementById("logoutOptions").style.display = "block";
  }

  function handleLogoutReason(reason) {
    // Tu peux aussi envoyer cette raison au serveur avec fetch/AJAX si tu veux.
    console.log("Raison de déconnexion :", reason);

    // Rediriger vers logout.php après choix
    window.location.href = "index.php";
  }

  let selectedReason = '';

function showEmailConfirm(reason) {
  selectedReason = reason;

  const reasonLabels = {
    pause: "faire une pause",
    dislike: "vous n’avez pas aimé l’application",
    confused: "vous êtes perdu(e)"
  };

  document.getElementById('reasonText').innerText = 
    `Vous avez choisi de ${reasonLabels[reason]}. Veuillez confirmer avec votre email.`;

  document.getElementById('logoutReasons').style.display = 'none';
  document.getElementById('emailConfirm').style.display = 'block';
}

function confirmLogout() {
  const email = document.getElementById('userEmail').value;

  if (!email) {
    alert("Veuillez entrer votre email.");
    return;
  }

  // Envoie vers logout.php avec email et raison
  window.location.href = `logout.php?reason=${encodeURIComponent(selectedReason)}&email=${encodeURIComponent(email)}`;
}

function closeModal() {
  document.getElementById('logoutModal').style.display = 'none';
  document.getElementById('logoutReasons').style.display = 'block';
  document.getElementById('emailConfirm').style.display = 'none';
  document.getElementById('userEmail').value = '';
}
</script>

</body>
</html>
