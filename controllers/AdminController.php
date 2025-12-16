<?php
require_once 'models/Avatar.php';
require_once 'models/World.php';

class AdminController
{
    public function __construct()
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
            header('Location: index.php');
            exit();
        }
    }

    public function dashboard()
    {
        $avatarModel = new Avatar();
        $worldModel = new World();

        $avatars = $avatarModel->getAll();
        $worlds = $worldModel->getAll();

        require_once 'views/admin/dashboard.php';
    }

    // Avatar actions
    public function addAvatar()
    {
        require_once 'views/admin/add_avatar.php';
    }

    public function storeAvatar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $model = $_POST['model'];

            // Handle Image Upload
            $imagePath = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                // Ensure target directory exists
                if (!is_dir('public/assets/avatars')) {
                    if (!is_dir('public/assets'))
                        mkdir('public/assets');
                    mkdir('public/assets/avatars');
                }

                $fileName = basename($_FILES['image']['name']);
                $targetFilePath = 'public/assets/avatars/' . $fileName;

                // If using root structure without public as document root, adjust
                if (!is_dir('public')) {
                    // Fallback to assets at root
                    if (!is_dir('assets/avatars'))
                        mkdir('assets/avatars', 0777, true);
                    $targetFilePath = 'assets/avatars/' . $fileName;
                }

                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                    $imagePath = $targetFilePath;
                }
            }

            $avatarModel = new Avatar();
            $avatarModel->add($name, $imagePath, $model);
            header('Location: index.php?page=admin&action=dashboard');
        }
    }

    // World actions
    public function addWorld()
    {
        require_once 'views/admin/add_world.php';
    }

    public function storeWorld()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $url = $_POST['url'];

            // Handle Image Upload
            $imagePath = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                // Ensure target directory exists
                if (!is_dir('public/assets/worlds')) {
                    if (!is_dir('public/assets'))
                        mkdir('public/assets');
                    mkdir('public/assets/worlds');
                }

                $fileName = basename($_FILES['image']['name']);
                $targetFilePath = 'public/assets/worlds/' . $fileName;

                // If using root structure without public as document root, adjust
                if (!is_dir('public')) {
                    // Fallback to assets at root
                    if (!is_dir('assets/worlds'))
                        mkdir('assets/worlds', 0777, true);
                    $targetFilePath = 'assets/worlds/' . $fileName;
                }

                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                    $imagePath = $targetFilePath;
                }
            }

            $worldModel = new World();
            $worldModel->add($name, $imagePath, $url);
            header('Location: index.php?page=admin&action=dashboard');
        }
    }

    public function index()
    {
        $this->dashboard();
    }
}
