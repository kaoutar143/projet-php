<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

?>
<nav>
    <p>Bienvenue Admin, <?= htmlspecialchars($_SESSION['user']['nom'] ?? '') ?></p>
    <ul>
        <li><a href="admin/dashboard.php">🏠 Dashboard</a></li>
        <li><a href="admin/chambres/index.php">🛏️ Gérer les chambres</a></li>
        <li><a href="admin/reservation/index.php">📋 Visualiser les réservations</a></li>
        <li><a href="admin/logout.php">🚪 Déconnexion</a></li>
    </ul>
</nav>
<hr>
