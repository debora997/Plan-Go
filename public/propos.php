<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>À propos | TodoList Pro</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Segoe UI", sans-serif;
    }
    body {
      background: linear-gradient(to right, #dfe9f3, #ffffff);
      color: #333;
      line-height: 1.6;
      padding: 30px;
    }
    header {
      text-align: center;
      margin-bottom: 40px;
    }
    header h1 {
      font-size: 2.8rem;
      color: #0077b6;
    }
    .section {
      max-width: 900px;
      margin: auto;
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      margin-bottom: 30px;
    }
    .section h2 {
      color: #023e8a;
      margin-bottom: 10px;
    }
    .contact {
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
    }
    .contact a {
      color: #0077b6;
      text-decoration: none;
    }
    footer {
      text-align: center;
      margin-top: 40px;
      font-size: 0.9rem;
      color: #555;
    }
  </style>
</head>
<body>

  <header>
    <h1>À propos de TodoList Pro</h1>
  </header>

  <div class="section">
    <h2>📝 Description</h2>
    <p>
      <strong>TodoList Pro</strong> est une application web intuitive, conçue pour vous aider à organiser vos tâches quotidiennes avec simplicité et efficacité.
      Que vous soyez étudiant, professionnel ou entrepreneur, vous pouvez créer, gérer, modifier ou supprimer vos tâches à tout moment.
    </p>
  </div>

  <div class="section">
    <h2>❓ Pourquoi cette application ?</h2>
    <p>
      Dans un monde en constante évolution, il est facile d’oublier les choses importantes. Nous avons créé TodoList Pro pour offrir une solution minimaliste mais puissante à la gestion du temps et des priorités. Cette application est née d’un besoin réel : rester productif et organisé, sans se perdre dans la complexité.
    </p>
  </div>

  <div class="section">
    <h2>✅ Avantages</h2>
    <ul>
      <li>✔ Interface claire et moderne</li>
      <li>✔ Ajout et modification de tâches en un clic</li>
      <li>✔ Aucune perte de données</li>
      <li>✔ Accessible depuis n’importe quel appareil</li>
      <li>✔ Gratuit, rapide et sécurisé</li>
    </ul>
  </div>

  <div class="section">
    <h2>🎯 Notre objectif</h2>
    <p>
      Notre ambition est d’améliorer la gestion du temps de chacun à travers une application web simple, rapide, sécurisée, et accessible à tous.
      <br>Nous voulons devenir votre partenaire quotidien pour vous aider à atteindre vos objectifs.
    </p>
  </div>

  <div class="section">
    <h2>📞 Contact</h2>
    <div class="contact">
      <p><i class="fas fa-envelope"></i> Email : <a href="mailto:support@todolistpro.com">support@todolistpro.com</a></p>
      <p><i class="fab fa-whatsapp"></i> WhatsApp : <a href="https://wa.me/22900000000">+229 00 00 00 00</a></p>
      <p><i class="fas fa-globe"></i> Site web : <a href="#">www.todolistpro.com</a></p>
    </div>
  </div>

  <footer>
    &copy; <?= date("Y") ?> TodoList Pro. Tous droits réservés.
  </footer>

</body>
</html>
