<?php

class AdminController extends Controller
{
    public function __construct()
    {
        // Ensure session is started (usually done in index.php)
        if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
            // Redirect to home if not admin
            header('Location: /SIO2/Challenge/kar4.leonie/public/');
            exit();
        }
    }

    public function dashboard()
    {
        $avatarModel = $this->model('Avatar');
        $worldModel = $this->model('World');

        $data = [
            'avatars' => $avatarModel->getAll(),
            'worlds' => $worldModel->getAll()
        ];

        $this->view('admin/dashboard', $data);
    }
}
