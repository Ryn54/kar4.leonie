<?php
require_once 'models/User.php';
require_once 'models/Avatar.php';
require_once 'models/World.php';

class AvatarController
{
    public function create()
    {
        if (isset($_SESSION['user_id'])) {
            header('Location: index.php?page=avatar&action=edit');
            exit();
        }

        $avatarModel = new Avatar();
        $worldModel = new World();

        $avatars = $avatarModel->getAll();
        $worlds = $worldModel->getAll();

        $currentUser = null;

        require_once 'views/avatar/create.php';
    }

    public function edit()
    {
        // Edit implies MODIFYING current user
        // If NOT logged in, redirect to login
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php');
            exit();
        }

        $avatarModel = new Avatar();
        $worldModel = new World();
        $userModel = new User();

        $avatars = $avatarModel->getAll();
        $worlds = $worldModel->getAll();
        $currentUser = $userModel->getById($_SESSION['user_id']);

        require_once 'views/avatar/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel = new User();

            // Check if it's an update or create
            if (isset($_SESSION['user_id'])) {
                // Update
                $password = !empty($_POST['password']) ? $_POST['password'] : null;
                $avatarId = !empty($_POST['avatar_id']) ? intval($_POST['avatar_id']) : null;
                $worldId = !empty($_POST['world_id']) ? intval($_POST['world_id']) : null;

                if ($userModel->update($_SESSION['user_id'], $password, $avatarId, $worldId)) {
                    header('Location: index.php?page=avatar&action=edit&msg=updated');
                } else {
                    echo "Erreur de mise à jour";
                }
            } else {
                // Create
                $username = $_POST['username'] ?? '';
                $password = $_POST['password'] ?? '';
                $avatarId = !empty($_POST['avatar_id']) ? intval($_POST['avatar_id']) : null;
                $worldId = !empty($_POST['world_id']) ? intval($_POST['world_id']) : null;

                if ($userModel->create($username, $password, 'user', $avatarId, $worldId)) {
                    header('Location: index.php?page=home&action=index&msg=created');
                } else {
                    header('Location: index.php?page=avatar&action=create&error=failed');
                }
            }
        }
    }

    public function index()
    {
        $this->create();
    }
}
