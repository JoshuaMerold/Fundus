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
    return view('checkout');
});

Route::get('/test', 'TestController@test');

Auth::routes();
Route::post('/register/create', 'Auth\RegisterController@registerNEW');

Route::get('/home', 'MainController@showContent')->middleware('auth');

Route::get('/{lesson}/show/{zusammenfassung}', 'LessonController@showContent')->middleware('auth');
Route::get('/{lesson}/show/{altklausur}', 'LessonController@showContent')->middleware('auth');
Route::get('/{lesson}/show/{karteikarte}', 'LessonController@showContent')->middleware('auth');

//Lessonsthings
Route::get('/add/lesson', 'LessonController@show')->middleware('auth');
Route::post('/add/lesson/create', 'LessonController@add')->middleware('auth');



Route::get('/add/module', function() {
  return view('forms.addModule');
})->middleware('auth');
Route::post('/add/module/create', 'ModuleController@add')->middleware('auth');

//Files Side
Route::get('/download/{file}', 'FileController@download')->middleware('auth');
Route::get('/{lesson}/add/File', 'FileController@add')->middleware('auth');
Route::post('/{lesson}/add/File/store', 'FileController@store')->middleware('auth');


//Comments SQLiteDatabase
Route::get('/{file}/add/comment', 'CommentController@show')->middleware('auth');
Route::post('/{file}/add/comment/store', 'CommentController@store')->middleware('auth');

//Votes
Route::get('/{file}/add/comment/up', 'VoteController@up')->middleware('auth');
Route::get('/{file}/add/comment/down', 'VoteController@down')->middleware('auth');
