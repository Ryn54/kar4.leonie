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

    public function getById($id)
    {
        $sql = "SELECT * FROM avatar WHERE idAvatar = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
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

    public function update($id, $name, $image, $model)
    {
        $sql = "UPDATE avatar SET nameAvatar = :name";
        $params = [':name' => $name, ':id' => $id];

        if ($image) {
            $sql .= ", imgAvatar = :image";
            $params[':image'] = $image;
        }

        if ($model) {
            $sql .= ", modelAvatar = :model";
            $params[':model'] = $model;
        }

        $sql .= " WHERE idAvatar = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }
}
