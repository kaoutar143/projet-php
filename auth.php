<?php
session_start();
include 'connexion.php'; // Assurez-vous que $conn est bien défini dans ce fichier

$email = $_POST['email'] ?? '';
$password = $_POST['mot_de_passe'] ?? '';

// Vérifie que les champs ne sont pas vides
if ($email && $password) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifie si l'utilisateur existe et si le mot de passe correspond (en clair ici)
    if ($user && $password === $user['mot_de_passe']) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'nom' => $user['nom'],
            'email' => $user['email'],
            'role' => $user['role']
        ];

        // Rediriger selon le rôle
        if ($user['role'] === 'admin') {
            header("Location: admin/dashboard.php");
        } else {
            header("Location: client/dashboard.php");
        }
        exit;
    } else {
        echo "Email ou mot de passe incorrect.";
    }
} else {
    echo "Veuillez remplir tous les champs.";
}
if ($user['role'] === 'admin') {
    header('Location: admin/dashboard.php');
} else {
    header('Location: client/dashboard.php');
}

?>

