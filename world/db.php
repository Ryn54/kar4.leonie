<?php
// Modèle de données pour le module World
class WorldDB
{
    private $host = "localhost";
    private $db_name = "leonie";
    private $username = "root";
    private $password = "";
    private $conn;

    public function getConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {

        }
        return $this->conn;
    }

    public function getUsers()
    {
        $db = $this->getConnection();
        if (!$db)
            return [];
        $sql = "SELECT u.idUser, u.username, u.password, a.imgAvatar, a.modelAvatar, w.nameWorld, w.urlWorld 
                FROM user u 
                INNER JOIN avatar a ON u.idAvatar = a.idAvatar 
                INNER JOIN world w ON u.idWorld = w.idWorld";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById($id)
    {
        $db = $this->getConnection();
        if (!$db)
            return null;
        $sql = "SELECT u.idUser, u.username, u.password, a.modelAvatar, w.nameWorld, w.urlWorld 
                FROM user u 
                LEFT JOIN avatar a ON u.idAvatar = a.idAvatar 
                LEFT JOIN world w ON u.idWorld = w.idWorld 
                WHERE u.idUser = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>