<?php
include '../admin_nav.php';
require '../../connexion.php';
$stmt = $conn->prepare("SELECT * FROM chambres ORDER BY numero ASC");
$stmt->execute();
$chambres = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Liste des chambres</h2>

<a href="add.php">➕ Ajouter une nouvelle chambre</a><br><br>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Numéro</th>
            <th>Type</th>
            <th>Prix (DH)</th>
            <th>Superficie (m²)</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($chambres as $chambre): ?>
            <tr>
                <td><?= htmlspecialchars($chambre['numero']) ?></td>
                <td><?= htmlspecialchars($chambre['type']) ?></td>
                <td><?= htmlspecialchars($chambre['prix']) ?></td>
                <td><?= htmlspecialchars($chambre['superficie']) ?></td>
                <td>
                    <a href="edit.php?id=<?= $chambre['id'] ?>">Modifier</a> |
                    <a href="delete.php?id=<?= $chambre['id'] ?>" onclick="return confirm('Supprimer cette chambre ?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>