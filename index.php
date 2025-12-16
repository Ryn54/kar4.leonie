<?php
session_start();

// Config
require_once 'config/db.php';

// Simple Router
$page = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? 'index';

// Map pages to controllers
$controllers = [
    'home' => 'HomeController',
    'auth' => 'AuthController',
    'admin' => 'AdminController',
    'avatar' => 'AvatarController'
];

if (array_key_exists($page, $controllers)) {
    $controllerName = $controllers[$page];
    $controllerFile = "controllers/$controllerName.php";

    if (file_exists($controllerFile)) {
        require_once $controllerFile;
        $controller = new $controllerName();

        if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            // Fallback default action
            $controller->index();
        }
    } else {
        echo "Controller not found.";
    }
} else {
    // 404
    require_once 'controllers/HomeController.php';
    $controller = new HomeController();
    $controller->index();
}
