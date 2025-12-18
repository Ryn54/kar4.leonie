<?php
require_once 'models/User.php';

class AuthController
{

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $userModel = new User();
            $user = $userModel->login($username, $password);

            if ($user) {
                $_SESSION['user_id'] = $user['idUser'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['userRole'];

                if ($user['userRole'] == 'admin') {
                    header('Location: index.php?page=admin&action=dashboard');
                } else {
                    header('Location: index.php?page=avatar&action=edit');
                }
            } else {
                $data = ['error' => 'Identifiants incorrects'];
                extract($data);
                require_once 'views/home/index.php';
            }
        } else {
            require_once 'views/home/index.php';
        }
    }

    public function logout()
    {
        session_destroy();
        header('Location: index.php');
    }
}
