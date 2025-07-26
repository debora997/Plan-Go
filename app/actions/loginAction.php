<?php
session_start();
require_once '../includes/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nom'] = $user['nom'];
        header("Location: ../public/dashboard.php");
        exit();
    } else {
        echo "Email ou mot de passe incorrect.";
    }
}
?>
