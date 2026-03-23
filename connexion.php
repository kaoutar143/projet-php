<?php
// connexion.php
$host = '127.0.0.1';
$db = 'db_reservation';
$user = 'root';
$pass = '';
$port = 4306;

try {
    $conn = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
