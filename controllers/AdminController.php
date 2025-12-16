<?php
require_once 'models/Avatar.php';
require_once 'models/World.php';
require_once 'models/User.php';

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
        $userModel = new User();

        $avatars = $avatarModel->getAll();
        $worlds = $worldModel->getAll();
        $users = $userModel->getAll();

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

    // --- USER ACTIONS ---
    public function editUser()
    {
        if (isset($_GET['id'])) {
            $userModel = new User();
            $user = $userModel->getById($_GET['id']);
            require_once 'views/admin/edit_user.php';
        }
    }

    public function updateUser()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $username = $_POST['username'];
            $role = $_POST['role'];
            $password = !empty($_POST['password']) ? $_POST['password'] : null;

            $userModel = new User();
            // Prevent deleting/demoting the main admin
            if ($id == 1 && $role != 'admin') {
                $role = 'admin';
            }

            if ($userModel->updateByAdmin($id, $username, $role, $password)) {
                header('Location: index.php?page=admin&action=dashboard&msg=user_updated');
            } else {
                header('Location: index.php?page=admin&action=editUser&id=' . $id . '&error=update_failed');
            }
        }
    }

    public function deleteUser()
    {
        $id = $_POST['id'] ?? $_GET['id'] ?? null;

        if ($id) {
            if ($id == $_SESSION['user_id'] || $id == 1) {
                header('Location: index.php?page=admin&action=dashboard&error=cannot_delete_self');
                exit();
            }

            $userModel = new User();
            if ($userModel->delete($id)) {
                header('Location: index.php?page=admin&action=dashboard&msg=user_deleted');
            } else {
                header('Location: index.php?page=admin&action=dashboard&error=delete_failed');
            }
        }
    }
}
