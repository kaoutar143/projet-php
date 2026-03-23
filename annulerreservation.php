<?php
session_start();
include '../connexion.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'client') {
    header('Location: ../login.php');
    exit;
}

$id_user = $_SESSION['user']['id'];
$id_reservation = $_GET['id'] ?? null;

if ($id_reservation) {
    // Vérifier que la réservation appartient à l'utilisateur
    $stmt = $conn->prepare("SELECT * FROM reservations WHERE id = ? AND id_user = ?");
    $stmt->execute([$id_reservation, $id_user]);
    $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($reservation) {
        // Mettre à jour le statut en 'Annulée'
        $update = $conn->prepare("UPDATE reservations SET statut = 'Annulée' WHERE id = ?");
        $update->execute([$id_reservation]);
        header('Location: reservations.php');
        exit;
    }
}

header('Location: reservations.php');
exit;
?>
