<?php
namespace App\Models;

class Book extends BaseModel {

    public function getCategory() {
        return Category::find($this->category_id);
    }

    public function getPublisher() {
        return Publisher::find($this->publisher_id);
    }

    public function getImage() {
        if ($this->image_id) {
            return Image::find($this->image_id);
        }
        return null;
    }
    


    public function save() {
        $sql = 'INSERT INTO books (title, isbn, publication_year, category_id, publisher_id, create_time) 
                VALUES (:title, :isbn, :publication_year, :category_id, :publisher_id, NOW())';
    
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':title', $this->title, \PDO::PARAM_STR);
        $stmt->bindParam(':isbn', $this->isbn, \PDO::PARAM_STR);
        $stmt->bindParam(':publication_year', $this->publication_year, \PDO::PARAM_INT);
        $stmt->bindParam(':category_id', $this->category_id, \PDO::PARAM_INT);
        $stmt->bindParam(':publisher_id', $this->publisher_id, \PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            // Set the id property to the last inserted ID
            $this->id = $this->db->lastInsertId();
            return true;
        }
        return false;
    }
    

    public function update() {
        $sql = 'UPDATE books SET title = :title, isbn = :isbn, publication_year = :publication_year, 
                category_id = :category_id, publisher_id = :publisher_id WHERE id = :id';
    
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':title', $this->title, \PDO::PARAM_STR);
        $stmt->bindParam(':isbn', $this->isbn, \PDO::PARAM_STR);
        $stmt->bindParam(':publication_year', $this->publication_year, \PDO::PARAM_INT);
        $stmt->bindParam(':category_id', $this->category_id, \PDO::PARAM_INT);
        $stmt->bindParam(':publisher_id', $this->publisher_id, \PDO::PARAM_INT);
        $stmt->bindParam(':id', $this->id, \PDO::PARAM_INT);
    
        return $stmt->execute();
    }
    
    public function delete() {
        $sql = 'DELETE FROM books WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $this->id, \PDO::PARAM_INT);
    
        return $stmt->execute();
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

    public function updateAuthors(int $bookId, array $authorIds) {
        $db = self::getDb();
    
        // Delete existing author links for the book
        $deleteSql = 'DELETE FROM book_authors WHERE book_id = :book_id';
        $deleteStmt = $db->prepare($deleteSql);
        $deleteStmt->bindParam(':book_id', $bookId, \PDO::PARAM_INT);
        $deleteStmt->execute();
    
        // Insert new author links
        $insertSql = 'INSERT INTO book_authors (book_id, author_id) VALUES (:book_id, :author_id)';
        $insertStmt = $db->prepare($insertSql);
    
        foreach ($authorIds as $authorId) {
            $insertStmt->bindParam(':book_id', $bookId, \PDO::PARAM_INT);
            $insertStmt->bindParam(':author_id', $authorId, \PDO::PARAM_INT);
            $insertStmt->execute();
        }
    }
    
    public static function filter($limit, $offset, $category = null, $authorName = null, $bookName = null, $sort = null) {
        $sql = 'SELECT books.* FROM books';
    
        // Join with book_authors and authors if authorName is provided
        if ($authorName) {
            $sql .= ' INNER JOIN book_authors ON books.id = book_authors.book_id';
            $sql .= ' INNER JOIN authors ON book_authors.author_id = authors.id';
        }
    
        $sql .= ' WHERE 1=1';
    
        // Filter by category
        if ($category) {
            $sql .= ' AND books.category_id = :category';
        }
    
        // Filter by author name
        if ($authorName) {
            $authorParts = explode(' ', trim($authorName));
            if (count($authorParts) > 1) {
                $sql .= ' AND (authors.first_name LIKE :firstName AND authors.last_name LIKE :lastName)';
            } else {
                $sql .= ' AND (authors.first_name LIKE :authorName OR authors.last_name LIKE :authorName)';
            }
        }
    
        // Filter by book name
        if ($bookName) {
            $sql .= ' AND books.title LIKE :bookName';
        }
    
        // Handle sorting (optional)
        if ($sort) {
            switch ($sort) {
                case 'title_asc':
                    $sql .= ' ORDER BY books.title ASC';
                    break;
                case 'title_desc':
                    $sql .= ' ORDER BY books.title DESC';
                    break;
                // Add other sorting options as needed
                default:
                    $sql .= ' ORDER BY books.id ASC';
            }
        } else {
            $sql .= ' ORDER BY books.id ASC';
        }
    
        $sql .= ' LIMIT :limit OFFSET :offset';
    
        $db = self::getDb();
        $stmt = $db->prepare($sql);
    
        // Bind parameters
        if ($category) {
            $stmt->bindParam(':category', $category, \PDO::PARAM_INT);
        }
        if ($authorName) {
            if (isset($authorParts) && count($authorParts) > 1) {
                $firstName = '%' . $authorParts[0] . '%';
                $lastName = '%' . $authorParts[1] . '%';
                $stmt->bindParam(':firstName', $firstName, \PDO::PARAM_STR);
                $stmt->bindParam(':lastName', $lastName, \PDO::PARAM_STR);
            } else {
                $searchAuthorName = '%' . $authorName . '%';
                $stmt->bindParam(':authorName', $searchAuthorName, \PDO::PARAM_STR);
            }
        }
        if ($bookName) {
            $searchBookName = '%' . $bookName . '%';
            $stmt->bindParam(':bookName', $searchBookName, \PDO::PARAM_STR);
        }
    
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
    
        $bookInstance = new self();
        return $bookInstance->castToModel($stmt->fetchAll());
    }
    
    
    
    
    public static function countFiltered($category = null, $authorName = null, $bookName = null) {
        $sql = 'SELECT COUNT(DISTINCT books.id) FROM books';
    
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
            $sql .= ' AND (authors.first_name LIKE :authorName OR authors.last_name LIKE :authorName)';
        }
    
        // Apply book name filter
        if ($bookName) {
            $sql .= ' AND books.title LIKE :bookName';
        }
    
        $db = self::getDb();
        $stmt = $db->prepare($sql);
    
        // Bind parameters
        if ($category) {
            $stmt->bindParam(':category', $category, \PDO::PARAM_INT);
        }
        if ($authorName) {
            $searchAuthorName = '%' . $authorName . '%';
            $stmt->bindParam(':authorName', $searchAuthorName, \PDO::PARAM_STR);
        }
        if ($bookName) {
            $searchBookName = '%' . $bookName . '%';
            $stmt->bindParam(':bookName', $searchBookName, \PDO::PARAM_STR);
        }
    
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    
}
