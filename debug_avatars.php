<?php
require_once 'config/db.php';
require_once 'models/Avatar.php';

$model = new Avatar();
$avatars = $model->getAll();

echo "<h1>Debug Avatars</h1>";
echo "<table border='1'><tr><th>ID</th><th>Nom</th><th>Image</th><th>Model Path</th><th>Fichier existe ?</th></tr>";

foreach ($avatars as $av) {
    echo "<tr>";
    echo "<td>" . $av['idAvatar'] . "</td>";
    echo "<td>" . $av['nameAvatar'] . "</td>";
    echo "<td>" . $av['imgAvatar'] . "</td>";
    echo "<td>" . $av['modelAvatar'] . "</td>";

    $path = $av['modelAvatar'];
    $exists = "NON";
    if ($path && file_exists($path)) {
        $exists = "OUI";
    } elseif ($path && file_exists(__DIR__ . '/' . $path)) {
        $exists = "OUI (Relatif)";
    }

    echo "<td>" . $exists . "</td>";
    echo "</tr>";
}
echo "</table>";
?>