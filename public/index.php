<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>PLAN&GO</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #74ebd5, #ACB6E5);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            background-color: rgba(255, 255, 255, 0.5);
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        nav a {
            margin-left: 20px;
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.3s;
        }

        nav a:hover {
            color: #007BFF;
        }

        .main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }
        .content-wrapper {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 40px;
    flex-wrap: wrap; /* Pour que ça s'adapte sur mobile */
    max-width: 1000px;
    width: 100%;
}
.text-content {
    flex: 1;
    color: #fff;
    min-width: 300px;
}
.image-content {
    flex: 1;
    min-width: 300px;
    text-align: center;
}

.image-content img {
    max-width: 100%;
    height: auto;
    border-radius: 0px;
}

        .content {
            text-align: center;
            color: #fff;
            max-width: 700px;
        }

        .content h1 {
            font-size: 48px;
            margin-bottom: 20px;
            
        }

        .content p {
            font-size: 20px;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .content .btn {
            display: inline-block;
            padding: 15px 30px;
            background-color:rgb(79, 154, 235);
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            border-radius: 25px;
            transition: background-color 0.3s;
        }

        .content .btn:hover {
            background-color:rgb(15, 43, 73);
        }

        footer {
            background-color: rgba(251, 251, 251, 0.9);
            text-align: center;
            padding: 15px;
            font-size: 14px;
            color: #444;
        }
        
    </style>
</head>
<body>

<header>
    <img src="assets/img/plan_go.png" alt="" style="height: 70px; widht: 100px;" >
    <!-- <div class="">Plan&Go</div> -->
    <nav>
        <a href="#">Accueil</a>
        <a href="propos.php">À propos</a>
        <a href="login.php">Connexion</a> <!-- Redirige vers la page avec la To-Do List -->
    </nav>
</header>

<main class="main">
     <div class="content-wrapper">
    <div class="content">
        <h1>Organisez votre vie, une tâche à la fois.</h1>
        <p>Bienvenue sur <strong>Plan&Go</strong> – votre assistant personnel pour gérer vos journées avec efficacité, simplicité et style.</p>

        <p>Ajoutez, planifiez et réalisez vos objectifs, que ce soit pour le travail, les études ou vos projets personnels.</p>
        <a href="MainDashboard.php" class="btn">Commencer maintenant</a>
    </div>
    </div>
    <div class="image-content">
<img src="assets/img/To_do2.png" alt="">
    </div>
</main>

<footer id="apropos">
    <p>To-Do List Pro est une application conçue pour améliorer votre productivité et simplifier votre quotidien. Commencez aujourd'hui et voyez la différence.</p>
    <p>&copy; Débora et Joanitha 2025</p>
</footer>

</body>
</html>
