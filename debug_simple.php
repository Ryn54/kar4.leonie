<?php
require_once 'config/db.php';
require_once 'models/Avatar.php';

$model = new Avatar();
$avatars = $model->getAll();

foreach ($avatars as $av) {
    echo "ID: " . $av['idAvatar'] . "\n";
    echo "Name: " . $av['nameAvatar'] . "\n";
    echo "Model Path: '" . $av['modelAvatar'] . "'\n";

    $path = $av['modelAvatar'];
    if (empty($path)) {
        echo "Status: Empty path\n";
    } elseif (file_exists($path)) {
        echo "Status: FOUND\n";
    } else {
        echo "Status: NOT FOUND (Checked: " . realpath($path) . ")\n";
    }
    echo "------------------\n";
}
?>