<?php
session_start();

if (isset($_GET['reason']) && isset($_GET['email'])) {
    $reason = $_GET['reason'];
    $email = $_GET['email'];

    // Enregistrer le feedback
    $log = date("Y-m-d H:i:s") . " | Email: $email | Raison: $reason\n";
    file_put_contents("logout_feedback.txt", $log, FILE_APPEND);
}

// Déconnexion
session_destroy();
header("Location: login.php");
exit;
?>
