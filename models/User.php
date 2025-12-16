<?php

class User
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
    }

    public function getAll()
    {
        $sql = "SELECT * FROM user";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function login($username, $password)
    {
        $sql = "SELECT * FROM user WHERE username = :username";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Note: Password verification might need adjustment if using double-hashing logic
        // Current implementation assumes standard password_verify (bcrypt) on server side
        // If client sends SHA-256, server stores bcrypt(SHA-256).
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function create($username, $password, $role = 'user', $avatarId = null, $worldId = null)
    {
        $sql = "INSERT INTO user (username, password, userRole, idAvatar, idWorld) VALUES (:username, :password, :role, :avatarId, :worldId)";
        $stmt = $this->db->prepare($sql);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':avatarId', $avatarId);
        $stmt->bindParam(':worldId', $worldId);
        return $stmt->execute();
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM user WHERE idUser = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $password = null, $avatarId = null, $worldId = null)
    {
        $sql = "UPDATE user SET ";
        $params = [':id' => $id];
        $updates = [];

        if ($password) {
            $updates[] = "password = :password";
            $params[':password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        if ($avatarId) {
            $updates[] = "idAvatar = :avatarId";
            $params[':avatarId'] = $avatarId;
        }
        if ($worldId) {
            $updates[] = "idWorld = :worldId";
            $params[':worldId'] = $worldId;
        }

        if (empty($updates))
            return true; // Nothing to update

        $sql .= implode(", ", $updates);
        $sql .= " WHERE idUser = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM user WHERE idUser = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function updateByAdmin($id, $username, $role, $password = null)
    {
        $sql = "UPDATE user SET username = :username, userRole = :role";
        $params = [':username' => $username, ':role' => $role, ':id' => $id];

        if ($password) {
            $sql .= ", password = :password";
            // Check if password_needs_rehash might be better, but typically admin sets a new one
            // We assume $password is the plain text new password. 
            // If admin leaves it blank, controller should pass null.
            $params[':password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $sql .= " WHERE idUser = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }
}
