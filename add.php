<?php
include '../admin_nav.php';
require '../../connexion.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = trim($_POST['numero'] ?? '');
    $type = $_POST['type'] ?? '';
    $prix = $_POST['prix'] ?? '';
    $superficie = $_POST['superficie'] ?? '';

    // Validation simple
    if ($numero === '') $errors[] = "Le numéro est obligatoire.";
    if (!in_array($type, ['single', 'double', 'suite'])) $errors[] = "Type invalide.";
    if (!is_numeric($prix) || $prix <= 0) $errors[] = "Prix invalide.";
    if (!is_numeric($superficie) || $superficie <= 0) $errors[] = "Superficie invalide.";

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO chambres (numero, type, prix, superficie) VALUES (?, ?, ?, ?)");
        $stmt->execute([$numero, $type, $prix, $superficie]);
        header('Location: index.php');
        exit;
    }
}
?>

<h2>Ajouter une chambre</h2>

<?php if ($errors): ?>
    <ul style="color:red;">
        <?php foreach ($errors as $err): ?>
            <li><?= htmlspecialchars($err) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="POST">
    <label>Numéro :</label><br>
    <input type="text" name="numero" value="<?= htmlspecialchars($_POST['numero'] ?? '') ?>" required><br><br>

    <label>Type :</label><br>
    <select name="type" required>
        <option value="">-- Choisir --</option>
        <option value="single" <?= (($_POST['type'] ?? '') === 'single') ? 'selected' : '' ?>>Single</option>
        <option value="double" <?= (($_POST['type'] ?? '') === 'double') ? 'selected' : '' ?>>Double</option>
        <option value="suite" <?= (($_POST['type'] ?? '') === 'suite') ? 'selected' : '' ?>>Suite</option>
    </select><br><br>

    <label>Prix (DH) :</label><br>
    <input type="number" step="0.01" name="prix" value="<?= htmlspecialchars($_POST['prix'] ?? '') ?>" required><br><br>

    <label>Superficie (m²) :</label><br>
    <input type="number" name="superficie" value="<?= htmlspecialchars($_POST['superficie'] ?? '') ?>" required><br><br>

    <button type="submit">Ajouter</button>
</form>

<br>
<a href="index.php">← Retour à la liste</a>