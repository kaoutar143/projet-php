<?php
session_start();
class User {
    public $id;
    public $nom;
    public $email;
    public $role;

    public function __construct($id, $nom, $email, $role) {
        $this->id = $id;
        $this->nom = $nom;
        $this->email = $email;
        $this->role = $role;
    }

    public static function findById($conn, $id) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            return new User($data['id'], $data['nom'], $data['email'], $data['role']);
        }
        return null;
    }
}

?>
