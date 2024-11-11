<?php

//$router->get('/', function() { echo 'Dit is de index vanuit de route'; });
$router->setNamespace('\App\Controllers');
// $router->get('/', 'HomeController@index');
$router->get('/', 'DashboardController@index');

$router->get('/books', 'BooksController@index');
$router->get('/books/create', 'BooksController@create');
$router->post('/books/create', 'BooksController@store'); // this handles the create form submission
$router->get('/books/edit/{id}', 'BooksController@edit'); // show the edit form
$router->post('/books/edit/{id}', 'BooksController@update'); // handle the edit form submission
$router->post('/books/delete/{id}', 'BooksController@delete'); // deletion

$router->get('/authors', 'AuthorsController@index');
$router->get('/authors/create', 'AuthorsController@create');
$router->post('/authors/create', 'AuthorsController@store');
$router->get('/authors/edit/{id}', 'AuthorsController@edit');
$router->post('/authors/edit/{id}', 'AuthorsController@update');
$router->post('/authors/delete/{id}', 'AuthorsController@delete');

$router->get('/categories', 'CategoriesController@index');
$router->get('/categories', 'CategoriesController@index');
$router->get('/categories/create', 'CategoriesController@create');
$router->post('/categories/create', 'CategoriesController@store');
$router->get('/categories/edit/{id}', 'CategoriesController@edit');
$router->post('/categories/edit/{id}', 'CategoriesController@update');
$router->post('/categories/delete/{id}', 'CategoriesController@delete');


// api
$router->post('/api/books', 'api\BooksControllerAPI@store'); // Create a new book
$router->get('/api/books', 'api\BooksControllerAPI@index');// List all books
$router->get('/api/books/{id}', 'api\BooksControllerAPI@show'); // Retrieve a single book
$router->put('/api/books/{id}', 'api\BooksControllerAPI@update'); // Update a book
$router->delete('/api/books/{id}', 'api\BooksControllerAPI@delete'); // Delete a book

$router->post('/api/authors', 'api\AuthorsControllerAPI@store');
$router->get('/api/authors', 'api\AuthorsControllerAPI@index');
$router->get('/api/authors/{id}', 'api\AuthorsControllerAPI@show');
$router->put('/api/authors/{id}', 'api\AuthorsControllerAPI@update');
$router->delete('/api/authors/{id}', 'api\AuthorsControllerAPI@delete');

$router->post('/api/categories', 'api\CategoriesControllerAPI@store');
$router->get('/api/categories', 'api\CategoriesControllerAPI@index');
$router->get('/api/categories/{id}', 'api\CategoriesControllerAPI@show');
$router->put('/api/categories/{id}', 'api\CategoriesControllerAPI@update');
$router->delete('/api/categories/{id}', 'api\CategoriesControllerAPI@delete');




// these are the curl commands to test the api 

// curl -X POST https://127.0.0.1:56505/api/books -H "Content-Type: application/json" -d '{"title": "New Book", "isbn": "1234567890123", "publication_year": 2024, "category_id": 1, "publisher_id": 2}'
// curl -X GET https://127.0.0.1:56505/api/books
// curl -X GET https://127.0.0.1:56505/api/books/31
// curl -X PUT https://127.0.0.1:56505/api/books/31 -H "Content-Type: application/json" -d '{"title": "Updated Title"}'
// curl -X DELETE https://127.0.0.1:56505/api/books/26