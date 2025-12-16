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

    public function index()
    {
        $this->dashboard();
    }

    // --- AVATAR ACTIONS ---
    public function addAvatar()
    {
        require_once 'views/admin/add_avatar.php';
    }

    public function storeAvatar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];

            // Handle Image Upload
            $imagePath = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                // Ensure target directory exists (Checking both public/assets and local assets for flexibility)
                $targetDir = 'public/assets/avatars/';
                if (!is_dir($targetDir)) {
                    if (is_dir('assets'))
                        $targetDir = 'assets/avatars/';
                    else
                        mkdir($targetDir, 0777, true);
                }

                $fileName = basename($_FILES['image']['name']);
                $targetFilePath = $targetDir . $fileName;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                    $imagePath = $targetFilePath;
                }
            }

            // Handle Model Upload (.glb)
            $modelPath = '';
            if (isset($_FILES['model']) && $_FILES['model']['error'] == 0) {
                $targetDir = 'public/assets/models/';
                if (!is_dir($targetDir)) {
                    if (is_dir('assets'))
                        $targetDir = 'assets/models/';
                    else
                        mkdir($targetDir, 0777, true);
                }

                $fileName = basename($_FILES['model']['name']);
                $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                if (strtolower($ext) == 'glb') {
                    $targetFilePath = $targetDir . $fileName;
                    if (move_uploaded_file($_FILES['model']['tmp_name'], $targetFilePath)) {
                        $modelPath = $targetFilePath;
                    }
                }
            }

            $avatarModel = new Avatar();
            $avatarModel->add($name, $imagePath, $modelPath);
            header('Location: index.php?page=admin&action=dashboard');
        }
    }

    public function editAvatar()
    {
        if (isset($_GET['id'])) {
            $avatarModel = new Avatar();
            $avatar = $avatarModel->getById($_GET['id']);
            require_once 'views/admin/edit_avatar.php';
        }
    }

    public function updateAvatar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];

            // Handle Image Upload
            $imagePath = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $targetDir = 'public/assets/avatars/';
                if (!is_dir($targetDir)) {
                    if (is_dir('assets'))
                        $targetDir = 'assets/avatars/';
                    else
                        mkdir($targetDir, 0777, true);
                }

                $fileName = basename($_FILES['image']['name']);
                $targetFilePath = $targetDir . $fileName;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                    $imagePath = $targetFilePath;
                }
            }

            // Handle Model Upload
            $modelPath = null;
            if (isset($_FILES['model']) && $_FILES['model']['error'] == 0) {
                $targetDir = 'public/assets/models/';
                if (!is_dir($targetDir)) {
                    if (is_dir('assets'))
                        $targetDir = 'assets/models/';
                    else
                        mkdir($targetDir, 0777, true);
                }

                $fileName = basename($_FILES['model']['name']);
                $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                if (strtolower($ext) == 'glb') {
                    $targetFilePath = $targetDir . $fileName;
                    if (move_uploaded_file($_FILES['model']['tmp_name'], $targetFilePath)) {
                        $modelPath = $targetFilePath;
                    }
                }
            }

            $avatarModel = new Avatar();
            $avatarModel->update($id, $name, $imagePath, $modelPath);
            header('Location: index.php?page=admin&action=dashboard');
        }
    }

    // --- WORLD ACTIONS ---
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
                $targetDir = 'public/assets/worlds/';
                if (!is_dir($targetDir)) {
                    if (is_dir('assets'))
                        $targetDir = 'assets/worlds/';
                    else
                        mkdir($targetDir, 0777, true);
                }

                $fileName = basename($_FILES['image']['name']);
                $targetFilePath = $targetDir . $fileName;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                    $imagePath = $targetFilePath;
                }
            }

            $worldModel = new World();
            $worldModel->add($name, $imagePath, $url);
            header('Location: index.php?page=admin&action=dashboard');
        }
    }

    public function editWorld()
    {
        if (isset($_GET['id'])) {
            $worldModel = new World();
            $world = $worldModel->getById($_GET['id']);
            require_once 'views/admin/edit_world.php';
        }
    }

    public function updateWorld()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $url = $_POST['url'];

            $imagePath = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $targetDir = 'public/assets/worlds/';
                if (!is_dir($targetDir)) {
                    if (is_dir('assets'))
                        $targetDir = 'assets/worlds/';
                    else
                        mkdir($targetDir, 0777, true);
                }

                $fileName = basename($_FILES['image']['name']);
                $targetFilePath = $targetDir . $fileName;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                    $imagePath = $targetFilePath;
                }
            }

            $worldModel = new World();
            $worldModel->update($id, $name, $imagePath, $url);
            header('Location: index.php?page=admin&action=dashboard');
        }
    }
}
