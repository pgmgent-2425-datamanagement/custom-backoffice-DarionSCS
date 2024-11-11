<?php

namespace App\Controllers;

class CategoriesController extends BaseController {

    public static function index () {

        self::loadView('categories', [
            'title' => 'Categories'
        ]);
    }

}