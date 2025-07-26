<?php
session_start();
require_once '../config/database.php';

$register_errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'] ?? '';
    $email = $_POST['email'] ?? '';
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';

    // Vérification des champs
    if (empty($nom) || empty($email) || empty($mot_de_passe)) {
        $register_errors[] = "Tous les champs sont obligatoires.";
    } else {
        // Vérifie si l'email existe déjà
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            $register_errors[] = "Cet email est déjà utilisé.";
        } else {
            // Hash du mot de passe
            $hashed_password = password_hash($mot_de_passe, PASSWORD_DEFAULT);

            // Insertion dans la base de données
            $insert = $pdo->prepare("INSERT INTO users (nom, email, mot_de_passe) VALUES (?, ?, ?)");
            $insert->execute([$nom, $email, $hashed_password]);

            // Stocker les infos utilisateur en session
            $_SESSION['user'] = [
                'nom' => $nom,
                'email' => $email
            ];

            // ✅ Redirection correcte
            header('Location: /TODOLIST/public/dashboard.php');
exit();
        }
    }

    // Si erreur : redirection vers l’inscription avec les erreurs
    $_SESSION['register_errors'] = $register_errors;
    header('Location: ../public/login.php');
    exit();
}
?>
