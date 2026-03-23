<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

include '../connexion.php';

// Récupérer toutes les réservations avec infos clients et chambres
$sql = "SELECT r.id, r.date_debut, r.date_fin, r.statut,
               c.numero, c.type, c.prix,
               u.nom, u.email
        FROM reservations r
        JOIN chambres c ON r.id_chambre = c.id
        JOIN users u ON r.id_user = u.id
        ORDER BY r.date_debut DESC";

$stmt = $conn->prepare($sql);
$stmt->execute();
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Toutes les réservations</h2>

<?php if (count($reservations) > 0): ?>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>Client</th>
            <th>Email</th>
            <th>Chambre</th>
            <th>Type</th>
            <th>Prix</th>
            <th>Date début</th>
            <th>Date fin</th>
            <th>Statut</th>
        </tr>
        <?php foreach ($reservations as $res): ?>
        <tr>
            <td><?= htmlspecialchars($res['nom']) ?></td>
            <td><?= htmlspecialchars($res['email']) ?></td>
            <td><?= htmlspecialchars($res['numero']) ?></td>
            <td><?= htmlspecialchars($res['type']) ?></td>
            <td><?= htmlspecialchars($res['prix']) ?> DH</td>
            <td><?= htmlspecialchars($res['date_debut']) ?></td>
            <td><?= htmlspecialchars($res['date_fin']) ?></td>
            <td><?= htmlspecialchars($res['statut']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>Aucune réservation trouvée.</p>
<?php endif; ?>

<br>
<a href="dashboard.php">⬅ Retour au tableau de bord</a>
