<?php
namespace App\Controllers\Api;

use App\Models\Category;
use App\Controllers\BaseController;

class CategoriesControllerAPI extends BaseController {

    public function index() {
        $categories = Category::all();
        header('Content-Type: application/json');
        echo json_encode($categories);
    }

    public function show($id) {
        $category = Category::find($id);
        if ($category) {
            header('Content-Type: application/json');
            echo json_encode($category);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Category not found']);
        }
    }

    public function store() {
        $data = json_decode(file_get_contents("php://input"), true);
        $category = new Category();
        $category->category_name = $data['category_name'];

        if ($category->save()) {
            http_response_code(201);
            echo json_encode(['message' => 'Category created', 'category' => $category]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to create category']);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        $category = Category::find($id);

        if (!$category) {
            http_response_code(404);
            echo json_encode(['error' => 'Category not found']);
            return;
        }

        $category->category_name = $data['category_name'];

        if ($category->update()) {
            echo json_encode(['message' => 'Category updated', 'category' => $category]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to update category']);
        }
    }

    public function delete($id) {
        $category = Category::find($id);

        if (!$category) {
            http_response_code(404);
            echo json_encode(['error' => 'Category not found']);
            return;
        }

        if ($category->delete()) {
            echo json_encode(['message' => 'Category deleted']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to delete category']);
        }
    }
}
