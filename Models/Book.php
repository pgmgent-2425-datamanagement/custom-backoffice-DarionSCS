<?php
namespace App\Models;

class Book extends BaseModel {

    public function getCategory() {
        return Category::find($this->category_id);
    }

    public function getPublisher() {
        return Publisher::find($this->publisher_id);
    }

    public static function paginate($limit, $offset) {
        $sql = 'SELECT * FROM books LIMIT :limit OFFSET :offset';
        $db = self::getDb();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
    
        $bookInstance = new self(); 
        return $bookInstance->castToModel($stmt->fetchAll());
    }
    
    public static function count() {
        $sql = 'SELECT COUNT(*) FROM books';
        $db = self::getDb();
        $stmt = $db->query($sql);
        return $stmt->fetchColumn();
    }

    protected static function getDb() {
        global $db;
        return $db;
    }
}
