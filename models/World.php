<?php

class World
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
    }

    public function getAll()
    {
        $sql = "SELECT * FROM world";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add($name, $image, $url)
    {
        $sql = "INSERT INTO world (nameWorld, imgWorld, urlWorld) VALUES (:name, :image, :url)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':url', $url);
        return $stmt->execute();
    }
}
