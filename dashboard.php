<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'client') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord Client</title>
</head>
<body>
    <h1>Bienvenue, <?= htmlspecialchars($_SESSION['user']['nom']) ?> (Client)</h1>

    <nav>
        <ul>
            <li><a href="reserver.php">📅 Réserver une chambre</a></li>
            <li><a href="mes_reservations.php">📝 Mes réservations</a></li>
            <li><a href="../logout.php">🚪 Déconnexion</a></li>
        </ul>
    </nav>
</body>
</html>

