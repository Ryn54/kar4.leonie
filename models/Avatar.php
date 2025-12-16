<?php

class Avatar
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
    }

    public function getAll()
    {
        $sql = "SELECT * FROM avatar";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add($name, $image, $model)
    {
        $sql = "INSERT INTO avatar (nameAvatar, imgAvatar, modelAvatar) VALUES (:name, :image, :model)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':model', $model);
        return $stmt->execute();
    }
}
