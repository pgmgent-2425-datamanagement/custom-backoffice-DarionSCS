<?php

//$router->get('/', function() { echo 'Dit is de index vanuit de route'; });
$router->setNamespace('\App\Controllers');
// $router->get('/', 'HomeController@index');
$router->get('/', 'DashboardController@index');
$router->get('/books', 'BooksController@index');
$router->get('/categories', 'CategoriesController@index');
$router->get('/authors', 'AuthorsController@index');