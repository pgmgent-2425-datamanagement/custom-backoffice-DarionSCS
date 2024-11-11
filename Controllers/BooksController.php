<?php

namespace App\Controllers;

class BooksController extends BaseController {

    public static function index () {

        self::loadView('/books', [
            'title' => 'Books'
        ]);
    }

}