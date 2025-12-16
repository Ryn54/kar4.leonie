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

    public function getById($id)
    {
        $sql = "SELECT * FROM world WHERE idWorld = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
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

    public function update($id, $name, $image, $url)
    {
        $sql = "UPDATE world SET nameWorld = :name, urlWorld = :url";
        $params = [':name' => $name, ':url' => $url, ':id' => $id];

        if ($image) {
            $sql .= ", imgWorld = :image";
            $params[':image'] = $image;
        }

        $sql .= " WHERE idWorld = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }
}
