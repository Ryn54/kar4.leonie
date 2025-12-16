<?php

class AuthController extends Controller
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $userModel = $this->model('User');
            $user = $userModel->login($username, $password);

            if ($user) {
                $_SESSION['user_id'] = $user['idUser'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['userRole'];

                if ($user['userRole'] == 'admin') {
                    header('Location: /SIO2/Challenge/kar4.leonie/public/admin/dashboard');
                } else {
                    header('Location: /SIO2/Challenge/kar4.leonie/public/avatar/create');
                }
            } else {
                $this->view('home/index', ['error' => 'Identifiants incorrects']);
            }
        } else {
            $this->view('home/index');
        }
    }

    public function logout()
    {
        session_destroy();
        header('Location: /SIO2/Challenge/kar4.leonie/public/');
    }
}
