<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'client') {
    header('Location: ../login.php');
    exit;
}

include '../connexion.php';

// Récupérer toutes les chambres (pas de filtre disponible)
$stmt = $conn->prepare("SELECT * FROM chambres");
$stmt->execute();
$chambres = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $chambre_id = $_POST['chambre_id'];
    $date_arrivee = $_POST['date_arrivee'];
    $date_depart = $_POST['date_depart'];
    $user_id = $_SESSION['user_id'];

    $insert = $conn->prepare("INSERT INTO reservations (id_user, id_chambre, date_debut, date_fin) VALUES (?, ?, ?, ?)");
    $insert->execute([$user_id, $chambre_id, $date_arrivee, $date_depart]);

    echo "<p style='color:green'>✅ Réservation enregistrée avec succès.</p>";
}
?>

<h2>Réserver une chambre</h2>

<form method="POST">
    <label>Choisir une chambre :</label>
    <select name="chambre_id" required>
        <option value="">-- Sélectionner --</option>
        <?php foreach ($chambres as $chambre): ?>
            <option value="<?= $chambre['id'] ?>">
                Chambre <?= htmlspecialchars($chambre['numero']) ?> - <?= htmlspecialchars($chambre['type']) ?> (<?= $chambre['prix'] ?> DH)
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Date d’arrivée :</label>
    <input type="date" name="date_arrivee" required><br><br>

    <label>Date de départ :</label>
    <input type="date" name="date_depart" required><br><br>

    <button type="submit">Réserver</button>
</form>

<br>
<a href="espace.php">⬅ Retour à l’accueil</a>



