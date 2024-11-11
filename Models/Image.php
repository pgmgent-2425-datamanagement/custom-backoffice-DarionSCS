<?php
namespace App\Models;

class Image extends BaseModel {
    public function save() {
        $sql = 'INSERT INTO images (entity_id, entity_type, image_url, upload_time) 
                VALUES (:entity_id, :entity_type, :image_url, :upload_time)';

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':entity_id', $this->entity_id, \PDO::PARAM_INT);
        $stmt->bindParam(':entity_type', $this->entity_type, \PDO::PARAM_STR);
        $stmt->bindParam(':image_url', $this->image_url, \PDO::PARAM_STR);
        $stmt->bindParam(':upload_time', $this->upload_time, \PDO::PARAM_STR);

        if ($stmt->execute()) {
            $this->id = $this->db->lastInsertId();
            return true;
        } else {
            error_log("Failed to insert image record: " . implode(", ", $stmt->errorInfo()));
            return false;
        }
    }

    public function update() {
        $sql = 'UPDATE images SET entity_id = :entity_id, entity_type = :entity_type, image_url = :image_url 
                WHERE id = :id';

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':entity_id', $this->entity_id, \PDO::PARAM_INT);
        $stmt->bindParam(':entity_type', $this->entity_type, \PDO::PARAM_STR);
        $stmt->bindParam(':image_url', $this->image_url, \PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->id, \PDO::PARAM_INT);

        return $stmt->execute();
    }
}
