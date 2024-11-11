<?php

namespace App\Controllers;

class AuthorsController extends BaseController {

    public static function index () {

        self::loadView('/authors', [
            'title' => 'Authors'
        ]);
    }

}