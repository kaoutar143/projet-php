<?php
include '../admin_nav.php';
require '../../connexion.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

$stmt = $conn->prepare("SELECT * FROM chambres WHERE id = ?");
$stmt->execute([$id]);
$chambre = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$chambre) {
    header('Location: index.php');
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = trim($_POST['numero'] ?? '');
    $type = $_POST['type'] ?? '';
    $prix = $_POST['prix'] ?? '';
    $superficie = $_POST['superficie'] ?? '';

    // Validation
    if ($numero === '') $errors[] = "Le numéro est obligatoire.";
    if (!in_array($type, ['single', 'double', 'suite'])) $errors[] = "Type invalide.";
    if (!is_numeric($prix) || $prix <= 0) $errors[] = "Prix invalide.";
    if (!is_numeric($superficie) || $superficie <= 0) $errors[] = "Superficie invalide.";

    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE chambres SET numero = ?, type = ?, prix = ?, superficie = ? WHERE id = ?");
        $stmt->execute([$numero, $type, $prix, $superficie, $id]);
        header('Location: index.php');
        exit;
    }
} else {
    // Préremplir le formulaire avec les données existantes
    $numero = $chambre['numero'];
    $type = $chambre['type'];
    $prix = $chambre['prix'];
    $superficie = $chambre['superficie'];
}
?>

<h2>Modifier la chambre</h2>

<?php if ($errors): ?>
    <ul style="color:red;">
        <?php foreach ($errors as $err): ?>
            <li><?= htmlspecialchars($err) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="POST">
    <label>Numéro :</label><br>
    <input type="text" name="numero" value="<?= htmlspecialchars($numero) ?>" required><br><br>

    <label>Type :</label><br>
    <select name="type" required>
        <option value="single" <?= ($type === 'single') ? 'selected' : '' ?>>Single</option>
        <option value="double" <?= ($type === 'double') ? 'selected' : '' ?>>Double</option>
        <option value="suite" <?= ($type === 'suite') ? 'selected' : '' ?>>Suite</option>
    </select><br><br>

    <label>Prix (DH) :</label><br>
    <input type="number" step="0.01" name="prix" value="<?= htmlspecialchars($prix) ?>" required><br><br>

    <label>Superficie (m²) :</label><br>
    <input type="number" name="superficie" value="<?= htmlspecialchars($superficie) ?>" required><br><br>

    <button type="submit">Enregistrer</button>
</form>

<br>
<a href="index.php">← Retour à la liste</a>