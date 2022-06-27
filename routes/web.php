<?php
use App\Http\Controllers\PostController;
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

// DB::listen(function ($event) {
//     dump($event->sql);
// });

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/post', 'PostController@index')->name('post.index');
    Route::post('/post/ajaxLoadPostTable', 'PostController@ajaxLoadPostTable')->name('post.ajaxLoadPostTable');
    Route::post('/post/update', 'PostController@update')->name('post.update');
    Route::post('/post/delete', 'PostController@delete')->name('post.delete');
    Route::get('/post/create', 'PostController@create')->name('post.create');
    Route::post('/post', 'PostController@store')->name('post.store');

    Route::get('/comment','CommentController@index')->name('comment.index');
    Route::get('/comment/create','CommentController@create')->name('comment.create');

    Route::get('eloquent', 'EloquentController@index')->name('eloquent.index');
});
