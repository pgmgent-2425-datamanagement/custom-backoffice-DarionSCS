<?php
namespace App\Controllers\Api;

use App\Models\Author;
use App\Controllers\BaseController;

class AuthorsControllerAPI extends BaseController {

    public function index() {
        $authors = Author::all();
        header('Content-Type: application/json');
        echo json_encode($authors);
    }

    public function show($id) {
        $author = Author::find($id);
        if ($author) {
            header('Content-Type: application/json');
            echo json_encode($author);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Author not found']);
        }
    }

    public function store() {
        $data = json_decode(file_get_contents("php://input"), true);
        $author = new Author();
        $author->first_name = $data['first_name'];
        $author->last_name = $data['last_name'];
        $author->bio = $data['bio'];
        $author->create_time = date('Y-m-d H:i:s');

        if ($author->save()) {
            http_response_code(201);
            echo json_encode(['message' => 'Author created', 'author' => $author]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to create author']);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        $author = Author::find($id);

        if (!$author) {
            http_response_code(404);
            echo json_encode(['error' => 'Author not found']);
            return;
        }

        $author->first_name = $data['first_name'];
        $author->last_name = $data['last_name'];
        $author->bio = $data['bio'];

        if ($author->update()) {
            echo json_encode(['message' => 'Author updated', 'author' => $author]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to update author']);
        }
    }

    public function delete($id) {
        $author = Author::find($id);

        if (!$author) {
            http_response_code(404);
            echo json_encode(['error' => 'Author not found']);
            return;
        }

        if ($author->delete()) {
            echo json_encode(['message' => 'Author deleted']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to delete author']);
        }
    }
}
