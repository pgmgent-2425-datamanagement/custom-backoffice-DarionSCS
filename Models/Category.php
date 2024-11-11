<?php
namespace App\Models;

class Category extends BaseModel {

    public function save() {
        $sql = 'INSERT INTO categories (category_name) VALUES (:category_name)';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':category_name', $this->category_name, \PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function update() {
        $sql = 'UPDATE categories SET category_name = :category_name WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':category_name', $this->category_name, \PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->id, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function delete() {
        $sql = 'DELETE FROM categories WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $this->id, \PDO::PARAM_INT);

        return $stmt->execute();
    }
}
