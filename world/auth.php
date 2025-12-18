<?php

session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userId'] ?? '';

    $typedPassword = $_POST['password'] ?? '';

    if (empty($userId) || empty($typedPassword)) {
        echo json_encode(['status' => 'error', 'message' => 'Données incomplètes']);
        exit;
    }

    $db = new WorldDB();
    $user = $db->getUserById($userId);

    if ($user && password_verify($typedPassword, $user['password'])) {


        $_SESSION['user_id'] = $user['idUser'];
        $_SESSION['username'] = $user['username'];


        echo json_encode([
            'status' => 'success',
            'username' => $user['username'],
            'world' => $user['nameWorld'],
            'url' => $user['urlWorld'],
            'avatarModel' => $user['modelAvatar']
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Mot de passe incorrect']);
    }
    exit;
}
?>