<?php
namespace App\Controllers;

use App\Models\Book;

class BooksController extends BaseController {

    public static function index() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10; 
        $offset = ($page - 1) * $limit;

        $books = Book::paginate($limit, $offset);  // Fetch limited books for the current page
        $totalBooks = Book::count(); 
        $totalPages = ceil($totalBooks / $limit); // Calculate total pages


        self::loadView('/books', [
            'title' => 'Books',
            'books' => $books,
            'totalBooks' => $totalBooks,
            'limit' => $limit,
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    }
}
