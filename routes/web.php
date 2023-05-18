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

Route::get('/home', [App\Http\Controllers\AdminController::class, 'index']);
Route::resource('/transactions', App\Http\Controllers\TransactionController::class);
Route::resource('/authors', App\Http\Controllers\AuthorController::class);
Route::resource('/catalogs', App\Http\Controllers\CatalogController::class);
Route::resource('/publishers', App\Http\Controllers\PublisherController::class);
Route::resource('/members', App\Http\Controllers\MemberController::class);
Route::resource('/books', App\Http\Controllers\BookController::class);

Route::get('api/authors', [App\Http\Controllers\AuthorController::class, 'api']);
Route::get('api/publishers', [App\Http\Controllers\PublisherController::class, 'api']);
Route::get('api/members', [App\Http\Controllers\MemberController::class, 'api']);
Route::get('api/books', [App\Http\Controllers\BookController::class, 'api']);
Route::get('api/transactions', [App\Http\Controllers\TransactionController::class, 'api']);

Route::get('test_spatie', [App\Http\Controllers\AdminController::class, 'test_spatie']);