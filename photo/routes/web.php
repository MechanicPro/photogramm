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
Route::get('/home', 'PostController@index');

Route::get('/post/create', function () {
    return view('posts.create');
});
Route::post('/post/store', 'PostController@store');
Route::delete('/post/destroy{id}', 'PostController@destroy');
Route::get('/post/show/user{id}', 'PostController@showPostUser');
Route::get('/post/update/{id}/{name}/{description}', function ($id, $name, $description) {
    return view('posts.edit')->with(['id' => $id,
        'name' => $name,
        'description' => $description]);
});
Route::put('/post/update/{id}', 'PostController@update');

Route::get('/photo/show{id}', 'PhotoController@show');
Route::get('/photo/create{id}', function ($id) {
    return view('photos.create')->with('post_id', $id);
});
Route::post('/photo/store{post_id}', 'PhotoController@store');
Route::delete('/photo/destroy/{id}/{post_id}', 'PhotoController@destroy');

Route::get('/photo/like/{id}/{user_id}/{post_id}', 'LikeController@like');
Route::get('/photo/dislike/{id}/{user_id}/{post_id}', 'LikeController@dislike');
