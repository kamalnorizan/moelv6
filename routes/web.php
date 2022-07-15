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
Route::get('user/ssoLogin', 'UserController@ssoLogin')->name('user.ssologin');

Route::middleware(['auth'])->group(function () {
    Route::get('user/getTokens','UserController@getTokens')->name('user.getTokens');
    Route::delete('user/destroyToken/{token_id}','UserController@destroyToken')->name('user.destroyToken');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/home/untukAdmin', 'HomeController@untukAdmin')->name('home.untukAdmin')->middleware('can:isAdmin');
    Route::get('/home/untukGuru', 'HomeController@untukGuru')->name('home.untukGuru')->middleware('can:isGuru');
    Route::get('/home/untukBpsh', 'HomeController@untukBpsh')->name('home.untukBpsh')->middleware('can:isBpsh');
    Route::get('/post', 'PostController@index')->name('post.index');
    Route::post('/post/ajaxLoadPostTable', 'PostController@ajaxLoadPostTable')->name('post.ajaxLoadPostTable');
    Route::post('/post/update', 'PostController@update')->name('post.update');
    Route::post('/post/delete', 'PostController@delete')->name('post.delete');
    Route::get('/post/create', 'PostController@create')->name('post.create');
    Route::post('/post', 'PostController@store')->name('post.store');
    Route::post('/post/storejqValidate', 'PostController@storejqValidate')->name('post.storejqValidate');

    Route::get('/post/testException','PostController@testException')->name('post.testException');

    Route::get('/post/{post}','PostController@show')->name('post.show');

    Route::get('/comment','CommentController@index')->name('comment.index');
    Route::get('/comment/create','CommentController@create')->name('comment.create');

    Route::get('eloquent', 'EloquentController@index')->name('eloquent.index');

    Route::get('users', 'UserController@index')->name('user.index');
});
