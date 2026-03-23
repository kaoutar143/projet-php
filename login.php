<?php
session_start();
include 'connexion.php'; // utilise la connexion centralisée

// Vérifie que la requête vient d’un formulaire POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['mot_de_passe'] ?? '';

    if ($email && $password) {
        try {
            // Préparation de la requête
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND mot_de_passe = ?");
            $stmt->execute([$email, $password]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
          // Redirection selon le rôle
                if ($user['role'] === 'admin') {
                    header('Location: admin/dashboard.php');
                } else {
                    header('Location: client/espace.php');
                }
                exit;
            } 
         catch (PDOException $e) {
            echo "❌ Erreur : " . $e->getMessage();
        }
    } else {
        echo "❗ Veuillez remplir tous les champs.";
    }
}
?>

<!-- Formulaire HTML -->
<form method="POST" action="login.php">
  <label for="email">Email :</label>
  <input type="email" name="email" required><br>

  <label for="mot_de_passe">Mot de passe :</label>
  <input type="password" name="mot_de_passe" required><br>

  <button type="submit">Se connecter</button>
</form>

