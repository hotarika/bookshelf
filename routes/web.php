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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('/bookshelf', 'BookshelfController');
Route::get('/register-books', 'RegisterBooksController')->name('register-books');

// Async
Route::get('/async/bookshelf', 'AsynchronousController@getBookshelf')->name('async');
