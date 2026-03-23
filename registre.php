<?php
session_start();
include 'connexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $password = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (nom, email, mot_de_passe, role) VALUES (:nom, :email, :mot_de_passe, 'client')");
    $stmt->execute([
        'nom' => $nom,
        'email' => $email,
        'mot_de_passe' => $password
    ]);

    header("Location: login.php");
}

?>

<!DOCTYPE html>
<html>
<head><title>Inscription</title></head>
<body>
<h2>Inscription client</h2>
<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="POST" action="">
    Nom: <input type="text" name="nom" required><br>
    Email: <input type="email" name="email" required><br>
    Mot de passe: <input type="password" name="password" required><br>
    <button type="submit">S'inscrire</button>
</form>
<p>Déjà inscrit ? <a href="login.php">Connexion</a></p>
</body>
</html>
