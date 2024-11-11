<?php
namespace App\Controllers;

use App\Models\Category;

class CategoriesController extends BaseController {

    public static function index() {
        $categories = Category::all();
        self::loadView('categories/index', [
            'title' => 'Categories',
            'categories' => $categories
        ]);
    }

    public static function create() {
        self::loadView('categories/create', [
            'title' => 'Add New Category'
        ]);
    }

    public static function store() {
        $category = new Category();
        $category->category_name = $_POST['category_name'];

        if ($category->save()) {
            self::redirect('categories');
        } else {
            self::redirect('categories/create');
        }
    }

    public static function edit($id) {
        $category = Category::find($id);

        if (!$category) {
            self::redirect('categories');
            return;
        }

        self::loadView('categories/edit', [
            'title' => 'Edit Category',
            'category' => $category
        ]);
    }

    public static function update($id) {
        $category = Category::find($id);

        if (!$category) {
            self::redirect('/categories');
            return;
        }

        $category->category_name = $_POST['category_name'];

        if ($category->update()) {
            self::redirect('categories');
        } else {
            self::redirect('categories/edit/' . $id);
        }
    }

    public static function delete($id) {
        $category = Category::find($id);

        if ($category && $category->delete()) {
            self::redirect('categories');
        } else {
            self::redirect('categories');
        }
    }
}
