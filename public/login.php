<?php
session_start();
// fichier login.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Connexion/Inscription</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Montserrat:400,800');

* {
  box-sizing: border-box;
}

body {
  background: #f6f5f7;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  font-family: 'Montserrat', sans-serif;
}

.container {
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 14px 28px rgba(0,0,0,0.25),
              0 10px 10px rgba(0,0,0,0.22);
  position: relative;
  overflow: hidden;
  width: 900px;
  max-width: 100%;
  min-height: 550px;
  display: flex;
}

.form-container {
  position: absolute;
  top: 0;
  height: 100%;
  transition: all 0.6s ease-in-out;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  width: 50%;
  padding: 0 50px;
  text-align: center;
  background-color: #ffffff;
}

.sign-in-container {
  left: 0;
  z-index: 2;
}

.sign-up-container {
  left: 0;
  opacity: 0;
  z-index: 1;
}

.container.right-panel-active .sign-up-container {
  transform: translateX(100%);
  opacity: 1;
  z-index: 5;
}

.container.right-panel-active .sign-in-container {
  transform: translateX(100%);
  opacity: 0;
  z-index: 1;
}

button {
  border: none;
  padding: 12px 45px;
  background-color: #74ebd5;
  color: #fff;
  font-size: 12px;
  font-weight: bold;
  letter-spacing: 1px;
  text-transform: uppercase;
  border-radius: 20px;
  cursor: pointer;
  margin-top: 20px;
}

button.ghost {
  background-color: transparent;
  border: 2px solid #fff;
}

input {
  background-color: #eee;
  border: none;
  padding: 12px 15px;
  margin: 8px 0;
  width: 100%;
  border-radius: 8px;
}

.social-container {
  margin: 20px 0;
}

.social {
  border: 1px solid #ccc;
  border-radius: 50%;
  display: inline-flex;
  justify-content: center;
  align-items: center;
  margin: 0 5px;
  height: 40px;
  width: 40px;
  font-weight: bold;
  color: #74ebd5;
  cursor: pointer;
}

a {
  color: #333;
  font-size: 14px;
  text-decoration: none;
  margin-top: 10px;
}

/* Overlay */
.overlay-container {
  position: absolute;
  top: 0;
  left: 50%;
  width: 50%;
  height: 100%;
  overflow: hidden;
  transition: transform 0.6s ease-in-out;
  z-index: 100;
}

.overlay {
  background: linear-gradient(135deg, #74ebd5, #ACB6E5);
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;
  color: #fff;
  position: relative;
  left: -100%;
  height: 100%;
  width: 200%;
  transform: translateX(0);
  transition: transform 0.6s ease-in-out;
}

.container.right-panel-active .overlay-container {
  transform: translateX(-100%);
}

.container.right-panel-active .overlay {
  transform: translateX(50%);
}

.overlay-panel {
  position: absolute;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: 0 40px;
  text-align: center;
  top: 0;
  height: 100%;
  width: 50%;
  transform: translateX(0);
  transition: transform 0.6s ease-in-out;
}

.overlay-left {
  transform: translateX(-20%);
}

.container.right-panel-active .overlay-left {
  transform: translateX(0);
}

.overlay-right {
  right: 0;
  transform: translateX(0);
}

.container.right-panel-active .overlay-right {
  transform: translateX(20%);
}

    </style>
  <div class="container" id="container">
  
    <!-- INSCRIPTION --> 
     <form action="../actions/registerAction.php" method="POST">
    <div class="form-container sign-up-container">
      
        <h1>Créer un Compte</h1>
        <p>Bienvenue sur Plan&Go</p>
        <input type="text" name="nom" placeholder="Nom" required/>
    <input type="email" name="email" placeholder="Email" required/>
<input type="password" name="mot_de_passe" placeholder="Mot de Passe" required/>

        <button type="submit">S'inscrire</button> 
      
    </div>
      </form>
      <!-- AFFICHAGE DES ERREURS -->
              <?php if (!empty($register_errors)): ?>
    <div style="color:red;">
        <?php foreach ($register_errors as $error): ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- MESSAGE DE SUCCÈS -->
<?php if (!empty($register_success)): ?>
    <div style="color:green;">
        <p><?= htmlspecialchars($register_success) ?></p>
    </div>
<?php endif; ?>
    <!-- CONNEXION -->
     <form action="../actions/loginAction.php" method="POST" class="sign-in-form">
    <div class="form-container sign-in-container">
      
        <h1>Connexion</h1>
        <p>Bienvenue sur ta Page de Connexion</p>
        <input type="email" name="email" placeholder="Email" required/>
<input type="password" name="password" placeholder="Mot de Passe" required/>
        <a href="#">Mot de Passe Oublié?</a>
        <button type="submit">Se Connecter</button>
      
    </div>
     </form>
    <!-- Overlay Panel -->
    <div class="overlay-container">
      <div class="overlay">
        <div class="overlay-panel overlay-left">
          <h1>Contente de te Revoir!</h1>
          <p>Pour rester connecter avec nous, connecte toi avec tes Informations Personnelles</p>
          <button class="ghost" id="signIn">SE CONNECTER</button>
        </div>
        <div class="overlay-panel overlay-right">
          <h1>Salut, Ami!</h1>
          <p>Entre tes informations Personnelles et commence ton Voyage avec nous</p>
          <button class="ghost" id="signUp">S'INSCRIRE</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');

signUpButton.addEventListener('click', () => {
  container.classList.add("right-panel-active");
});

signInButton.addEventListener('click', () => {
  container.classList.remove("right-panel-active");
});

  </script>
</body>
</html>
