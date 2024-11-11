<?php
namespace App\Models;

class Book extends BaseModel {

    public function getCategory() {
        return Category::find($this->category_id);
    }

    public function getPublisher() {
        return Publisher::find($this->publisher_id);
    }

    // this is so not all books are loaded at once, making it more efficient (in terms of memory)
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

    // to display authors in the book list
    public function getAuthors() {
        $sql = 'SELECT authors.first_name, authors.last_name FROM authors
                INNER JOIN book_authors ON authors.id = book_authors.author_id
                WHERE book_authors.book_id = :book_id';
    
        $db = self::getDb();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':book_id', $this->id, \PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public static function filter($limit, $offset, $category = null, $authorName = null) {
        $sql = 'SELECT books.* FROM books';
        
        // Join with book_authors and authors if authorName is provided
        if ($authorName) {
            $sql .= ' INNER JOIN book_authors ON books.id = book_authors.book_id';
            $sql .= ' INNER JOIN authors ON book_authors.author_id = authors.id';
        }
    
        $sql .= ' WHERE 1=1';
        
        // Apply category filter
        if ($category) {
            $sql .= ' AND books.category_id = :category';
        }
    
        // Apply author name filter
        if ($authorName) {
            $authorParts = explode(' ', trim($authorName));
            
            if (count($authorParts) > 1) {
                // If there are multiple words, assume first and last name
                $sql .= ' AND (authors.first_name LIKE :firstName AND authors.last_name LIKE :lastName)';
            } else {
                // If only one word, search in both first and last name columns
                $sql .= ' AND (authors.first_name LIKE :authorName OR authors.last_name LIKE :authorName)';
            }
        }
    
        $sql .= ' LIMIT :limit OFFSET :offset';
    
        $db = self::getDb();
        $stmt = $db->prepare($sql);
        
        if ($category) {
            $stmt->bindParam(':category', $category, \PDO::PARAM_INT);
        }
        
        if ($authorName) {
            if (isset($authorParts) && count($authorParts) > 1) {
                // Bind first and last name if both are provided
                $firstName = '%' . $authorParts[0] . '%';
                $lastName = '%' . $authorParts[1] . '%';
                $stmt->bindParam(':firstName', $firstName, \PDO::PARAM_STR);
                $stmt->bindParam(':lastName', $lastName, \PDO::PARAM_STR);
            } else {
                // Bind single name to authorName parameter
                $searchAuthorName = '%' . $authorName . '%';
                $stmt->bindParam(':authorName', $searchAuthorName, \PDO::PARAM_STR);
            }
        }
    
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
    
        $bookInstance = new self();
        return $bookInstance->castToModel($stmt->fetchAll());
    }
    
    
    public static function countFiltered($category = null, $authorName = null) {
        $sql = 'SELECT COUNT(DISTINCT books.id) FROM books';
    
        // Join with book_authors and authors if authorName is provided
        if ($authorName) {
            $sql .= ' INNER JOIN book_authors ON books.id = book_authors.book_id';
            $sql .= ' INNER JOIN authors ON book_authors.author_id = authors.id';
        }
    
        $sql .= ' WHERE 1=1';
    
        // apply category filter
        if ($category) {
            $sql .= ' AND books.category_id = :category';
        }
    
        // apply author name filter
        if ($authorName) {
            $sql .= ' AND (authors.first_name LIKE :authorName OR authors.last_name LIKE :authorName)';
        }
    
        $db = self::getDb();
        $stmt = $db->prepare($sql);
    
        if ($category) {
            $stmt->bindParam(':category', $category, \PDO::PARAM_INT);
        }
        if ($authorName) {
            $searchAuthorName = '%' . $authorName . '%';
            $stmt->bindParam(':authorName', $searchAuthorName, \PDO::PARAM_STR);
        }
    
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    
}
