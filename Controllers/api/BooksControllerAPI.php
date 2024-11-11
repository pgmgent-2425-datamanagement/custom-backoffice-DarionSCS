<?php
namespace App\Controllers\api;

use App\Models\Book;
use App\Controllers\BaseController;

class BooksControllerAPI extends BaseController {

    // List all books
    public function index() {
        $books = Book::all();
        header('Content-Type: application/json');
        echo json_encode($books);
    }

    // Show a single book
    public function show($id) {
        $book = Book::find($id);
        if ($book) {
            header('Content-Type: application/json');
            echo json_encode($book);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Book not found']);
        }
    }

    // Create a new book
    public function store() {
        $data = json_decode(file_get_contents("php://input"), true);
        $book = new Book();
        
        $book->title = $data['title'] ?? null;
        $book->isbn = $data['isbn'] ?? null;
        $book->publication_year = $data['publication_year'] ?? null;
        $book->category_id = $data['category_id'] ?? null;
        $book->publisher_id = $data['publisher_id'] ?? null;
        
        if ($book->save()) {
            http_response_code(201);
            header('Content-Type: application/json');
            echo json_encode(['message' => 'Book created successfully', 'book' => $book]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to create book']);
        }
    }

    // Update an existing book
    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        $book = Book::find($id);

        if (!$book) {
            http_response_code(404);
            echo json_encode(['error' => 'Book not found']);
            return;
        }

        $book->title = $data['title'] ?? $book->title;
        $book->isbn = $data['isbn'] ?? $book->isbn;
        $book->publication_year = $data['publication_year'] ?? $book->publication_year;
        $book->category_id = $data['category_id'] ?? $book->category_id;
        $book->publisher_id = $data['publisher_id'] ?? $book->publisher_id;

        if ($book->update()) {
            header('Content-Type: application/json');
            echo json_encode(['message' => 'Book updated successfully', 'book' => $book]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to update book']);
        }
    }

    // Delete a book
    public function delete($id) {
        $book = Book::find($id);
        
        if (!$book) {
            http_response_code(404);
            echo json_encode(['error' => 'Book not found']);
            return;
        }

        if ($book->delete()) {
            header('Content-Type: application/json');
            echo json_encode(['message' => 'Book deleted successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to delete book']);
        }
    }
}
