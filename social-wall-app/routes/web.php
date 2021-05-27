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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::post('/categories', 'App\Http\Controllers\CategoriesController@store');

Route::get('/categories', 'App\Http\Controllers\CategoriesController@create');

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

Route::get('/activity', [App\Http\Controllers\ActivityController::class, 'index'])->name('activity');

Route::post('/posts', 'App\Http\Controllers\PostsController@update')->name('posts');

Route::get('my_activity', [App\Http\Controllers\MyActivtiesController::class, 'index'])->name('my_activity');

Route::get('/calendar', 'App\Http\Controllers\CalendarController@index')->name('calendar');
