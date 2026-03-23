<?php
include '../admin_nav.php';
require '../../connexion.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $conn->prepare("DELETE FROM chambres WHERE id = ?");
    $stmt->execute([$id]);
}

header('Location: index.php');
exit;