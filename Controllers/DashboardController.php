<?php

namespace App\Controllers;

class DashboardController extends BaseController {

    public static function index () {

        self::loadView('/dashboard', [
            'title' => 'Dashboard'
        ]);
    }

}