<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function(){ return redirect('/home'); });
Route::get('/home', 'HomeController@index');
Route::get('/books/authors', ['as' => 'books.authors', 'uses' => 'BooksController@authors']);
Route::get('/books/author/{id}', ['as' => 'books.author', 'uses' => 'BooksController@author'])
    ->where(['id' => '[0-9]+']);
Route::resource('books', 'BooksController');

Auth::routes();
