<?php
session_start();

// Vérifier que l'utilisateur est connecté et que c'est un client
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'client') {
    header('Location: ../login.php');
    exit;
}

include '../connexion.php'; // fichier avec la connexion PDO dans $conn

$user_id = $_SESSION['user_id'];

try {
    $stmt = $conn->prepare("
        SELECT r.id, c.numero, c.type, r.date_debut, r.date_fin, r.statut
        FROM reservations r
        JOIN chambres c ON r.id_chambre = c.id
        WHERE r.id_user = ?
        ORDER BY r.date_debut DESC
    ");
    $stmt->execute([$user_id]);
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des réservations : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Réservations</title>
    <style>
        table { border-collapse: collapse; width: 80%; margin: 20px auto; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        th { background-color: #eee; }
        caption { font-size: 1.5em; margin-bottom: 10px; }
    </style>
</head>
<body>
    <h1>Bienvenue dans l’espace Client, <?= htmlspecialchars($_SESSION['username']) ?></h1>
    <a href="../logout.php">Déconnexion</a>

    <h2>Mes Réservations</h2>

    <?php if (count($reservations) > 0): ?>
        <table>
            <caption>Liste de vos réservations</caption>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Numéro Chambre</th>
                    <th>Type Chambre</th>
                    <th>Date Début</th>
                    <th>Date Fin</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $r): ?>
                <tr>
                    <td><?= htmlspecialchars($r['id']) ?></td>
                    <td><?= htmlspecialchars($r['numero']) ?></td>
                    <td><?= htmlspecialchars($r['type']) ?></td>
                    <td><?= htmlspecialchars($r['date_debut']) ?></td>
                    <td><?= htmlspecialchars($r['date_fin']) ?></td>
                    <td><?= htmlspecialchars($r['statut']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucune réservation trouvée.</p>
    <?php endif; ?>

</body>
</html>

