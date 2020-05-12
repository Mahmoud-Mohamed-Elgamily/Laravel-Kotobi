<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/403', function () {
    return view('auth.403');
});
Route::get('/sort/{sort_value}', 'HomeController@sort')->name('rate');
Route::get('book/chart', 'BooksController@chart');
Route::resource('book', 'BooksController');
Route::resource('category', 'CategoriesController');
Route::post('addfavorite', 'FavouriteController@addfavorite');
Route::post('removefavorite', 'FavouriteController@removefavorite');

