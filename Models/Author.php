<?php
namespace App\Models;

class Author extends BaseModel {

    public function save() {
        $sql = 'INSERT INTO authors (first_name, last_name, bio, create_time) 
                VALUES (:first_name, :last_name, :bio, :create_time)';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':first_name', $this->first_name, \PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $this->last_name, \PDO::PARAM_STR);
        $stmt->bindParam(':bio', $this->bio, \PDO::PARAM_STR);
        $stmt->bindParam(':create_time', $this->create_time, \PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function update() {
        $sql = 'UPDATE authors SET first_name = :first_name, last_name = :last_name, bio = :bio WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':first_name', $this->first_name, \PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $this->last_name, \PDO::PARAM_STR);
        $stmt->bindParam(':bio', $this->bio, \PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->id, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function delete() {
        $sql = 'DELETE FROM authors WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $this->id, \PDO::PARAM_INT);

        return $stmt->execute();
    }
}
