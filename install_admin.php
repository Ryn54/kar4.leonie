<?php
require_once 'config/db.php';
require_once 'models/User.php';

// 1. Simulate Client-Side Hash (SHA-256 of 'admin')
// This is what the Javascript sends to the server
$clientSideHash = hash('sha256', 'admin');

// 2. Create User using the Model
// The model will apply password_hash() on top of this
$userModel = new User();
$username = 'admin';
$role = 'admin';

// Check if exists first to avoid duplicates (optional but good)
$db = (new Database())->getConnection();
$stmt = $db->prepare("SELECT COUNT(*) FROM user WHERE username = :username");
$stmt->bindParam(':username', $username);
$stmt->execute();

if ($stmt->fetchColumn() > 0) {
    echo "L'utilisateur 'admin' existe déjà.";
} else {
    // Note: The User::create method takes ($username, $password, $role)
    // and performs password_hash($password, PASSWORD_DEFAULT)
    if ($userModel->create($username, $clientSideHash, $role)) {
        echo "Compte admin créé avec succès !<br>";
        echo "Username: admin<br>";
        echo "Password: admin<br>";
    } else {
        echo "Erreur lors de la création du compte.";
    }
}
