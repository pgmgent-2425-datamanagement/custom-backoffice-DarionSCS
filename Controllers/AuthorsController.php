<?php
namespace App\Controllers;

use App\Models\Author;

class AuthorsController extends BaseController {

    public static function index() {
        $authors = Author::all();
        self::loadView('authors/index', [
            'title' => 'Authors',
            'authors' => $authors
        ]);
    }

    public static function create() {
        self::loadView('authors/create', [
            'title' => 'Add New Author'
        ]);
    }

    public static function store() {
        $author = new Author();
        $author->first_name = $_POST['first_name'];
        $author->last_name = $_POST['last_name'];
        $author->bio = $_POST['bio'];
        $author->create_time = date('Y-m-d H:i:s');

        if ($author->save()) {
            self::redirect('authors');
        } else {
            self::redirect('authors/create');
        }
    }

    public static function edit($id) {
        $author = Author::find($id);

        if (!$author) {
            self::redirect('authors');
            return;
        }

        self::loadView('authors/edit', [
            'title' => 'Edit Author',
            'author' => $author
        ]);
    }

    public static function update($id) {
        $author = Author::find($id);

        if (!$author) {
            self::redirect('/authors');
            return;
        }

        $author->first_name = $_POST['first_name'];
        $author->last_name = $_POST['last_name'];
        $author->bio = $_POST['bio'];

        if ($author->update()) {
            self::redirect('authors');
        } else {
            self::redirect('authors/edit/' . $id);
        }
    }

    public static function delete($id) {
        $author = Author::find($id);

        if ($author && $author->delete()) {
            self::redirect('authors');
        } else {
            self::redirect('authors');
        }
    }
}
