<?php
namespace App\Controllers;

use App\Models\Book;
use App\Models\Category;

class BooksController extends BaseController {

    public static function index() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        // get filter parameters from slug
        $selectedCategory = isset($_GET['category']) ? (int)$_GET['category'] : null;
        $authorName = isset($_GET['author']) ? $_GET['author'] : null;

        // fetch categories for dropdown (filtering)
        $categories = Category::all();

        // apply filtering
        $books = Book::filter($limit, $offset, $selectedCategory, $authorName);
        $totalBooks = Book::countFiltered($selectedCategory, $authorName);
        $totalPages = ceil($totalBooks / $limit);

        self::loadView('/books', [
            'title' => 'Books',
            'books' => $books,
            'totalBooks' => $totalBooks,
            'limit' => $limit,
            'page' => $page,
            'totalPages' => $totalPages,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
            'authorName' => $authorName
        ]);
    }
}
