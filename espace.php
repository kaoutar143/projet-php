<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'client') {
    header('Location: ../login.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Espace Client</title>
</head>
<body>
    <h2>Bienvenue dans l’espace Client, <?= htmlspecialchars($_SESSION['username']) ?> (client)</h2>

    <nav>
        <ul>
            <li><a href="reserver.php">Réserver une chambre</a></li>
            <li><a href="mes_reservations.php">Mes réservations</a></li>
            <li><a href="../logout.php">Déconnexion</a></li>
        </ul>
    </nav>
</body>
</html>

