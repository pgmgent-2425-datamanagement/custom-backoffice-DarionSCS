<?php
namespace App\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use App\Models\Author;
use DateTime;

class BooksController extends BaseController {

    public static function index() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
    
        $selectedCategory = isset($_GET['category']) ? (int)$_GET['category'] : null;
        $authorName = isset($_GET['author']) ? $_GET['author'] : null;
        $sort = isset($_GET['sort']) ? $_GET['sort'] : null;
    
        $categories = Category::all();
        $authors = Author::all();
    
        $books = Book::filter($limit, $offset, $selectedCategory, $authorName, $sort);
        $totalBooks = Book::countFiltered($selectedCategory, $authorName);
        $totalPages = ceil($totalBooks / $limit);
    
        self::loadView('books/index', [
            'title' => 'Books',
            'books' => $books,
            'totalBooks' => $totalBooks,
            'limit' => $limit,
            'page' => $page,
            'totalPages' => $totalPages,
            'categories' => $categories,
            'authors' => $authors,
            'selectedCategory' => $selectedCategory,
            'authorName' => $authorName,
            'sort' => $sort
        ]);
    }
    
       // Show the form to create a new book
       public static function create() {
        $categories = Category::all();
        $publishers = Publisher::all();
        $authors = Author::all();
    
        self::loadView('books/create', [
            'title' => 'Add New Book',
            'categories' => $categories,
            'publishers' => $publishers,
            'authors' => $authors
        ]);
    }
    

    public static function edit($id) {
        $book = Book::find($id);
    
        if (!$book) {
            self::redirect('books');
            return;
        }
    
        $categories = Category::all();
        $publishers = Publisher::all();
        $authors = Author::all();
        $linkedAuthors = $book->getAuthors(); // Get authors currently linked to this book
    
        self::loadView('books/edit', [
            'title' => 'Edit Book',
            'book' => $book,
            'categories' => $categories,
            'publishers' => $publishers,
            'authors' => $authors,
            'linkedAuthors' => array_column($linkedAuthors, 'id')
        ]);
    }
    
        public static function update($id) {
            $book = Book::find($id);
        
            if (!$book) {
                self::redirect('books');
                return;
            }
        
            $book->title = $_POST['title'];
            $book->isbn = $_POST['isbn'];
            $book->publication_year = $_POST['publication_year'];
            $book->category_id = $_POST['category_id'];
            $book->publisher_id = $_POST['publisher_id'];
        
            if ($book->update()) {

                $selectedAuthors = $_POST['authors'] ?? [];
                $book->updateAuthors($book->id, $selectedAuthors);
        
                self::redirect('books');
            } else {
                self::redirect('books/edit/' . $id);
            }
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
        
        
    
        // deletion of a book
        public static function delete($id) {
            $book = Book::find($id);
            
            if ($book && $book->delete()) {
                self::redirect('books');
            } else {

                self::redirect('books');
            }
        }

    // Handle the form submission and create a new book
    public static function store() {
        $book = new Book();
        
        $book->title = $_POST['title'];
        $book->isbn = $_POST['isbn'];
        $book->publication_year = $_POST['publication_year'];
        $book->category_id = $_POST['category_id'];
        $book->publisher_id = $_POST['publisher_id'];
    
        if ($book->save()) {
            // linking authors if any were selected
            $selectedAuthors = $_POST['authors'] ?? [];
            $book->updateAuthors($book->id, $selectedAuthors);
    
            self::redirect('books');
        } else {
            self::redirect('books/create');
        }
    }
    
    

    
}
