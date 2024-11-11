<?php

//$router->get('/', function() { echo 'Dit is de index vanuit de route'; });
$router->setNamespace('\App\Controllers');
// $router->get('/', 'HomeController@index');
$router->get('/', 'DashboardController@index');

$router->get('/books', 'BooksController@index');
$router->get('/books/create', 'BooksController@create');
$router->post('/books/create', 'BooksController@store'); // this handles the create form submission
$router->get('/books/edit/(\d+)', 'BooksController@edit'); 
$router->post('/books/edit/(\d+)', 'BooksController@update'); // this handles the edit form submission
$router->post('/books/delete/(\d+)', 'BooksController@delete'); // deletion


$router->get('/categories', 'CategoriesController@index');
$router->get('/authors', 'AuthorsController@index');