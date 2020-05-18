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

Route::get('book/{book}/rate', 'BooksController@getRate');
Route::post('book/{book}/rate', 'BooksController@rate');

Route::resource('book', 'BooksController');
Route::resource('category', 'CategoriesController');


Route::get('/admin/users', 'AdminController@list_users')->name('list_users');
Route::post('/admin/user/promotion', 'AdminController@promotion')->name('promotion');
Route::post('/admin/user/activation', 'AdminController@activation')->name('activation');
Route::get('/admin/user/{user}/edit', 'AdminController@edit_user')->name('edit_user');
Route::post('/admin/user/{user}/edit', 'AdminController@update_user')->name('update_user');
Route::get('search', 'HomeController@search_books');
Route::post('addfavorite', 'FavouriteController@addfavorite');
Route::post('removefavorite', 'FavouriteController@removefavorite');
Route::post('addcomment', 'CommentController@create');
Route::post('/removecomment', 'CommentController@destroy')->name('comment.destroy');
Route::get('/myfavorite', 'FavouriteController@show')->name('favourite.show');

Route::post('/user/{uId}/lease/{bId}','LeaseController@store');

Route::get('/books/{category}', 'HomeController@category');
