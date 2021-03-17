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

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home.show');

Route::get('/articles', [App\Http\Controllers\ArticlesController::class, 'index'])->name('articles');
