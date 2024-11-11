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
    
        self::loadView('/books/index', [
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

        self::loadView('books/create', [
            'title' => 'Add New Book',
            'categories' => $categories,
            'publishers' => $publishers
        ]);
        
    }

    // Handle the form submission and create a new book
    public static function store() {
        $book = new Book();
        
        $book->title = $_POST['title'];
        $book->isbn = $_POST['isbn'];
        $book->publication_year = $_POST['publication_year'];
        $book->category_id = $_POST['category_id'];
        $book->publisher_id = $_POST['publisher_id'];
        $book->create_time = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
        
        if ($book->save()) {
            self::redirect('books');
        } else {
            // Handle any errors or redirect back to the form with an error message
            self::redirect('books/create');
        }
    }

    
}
