<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\StoreController;
use App\Models\Book;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('users')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/users', [AuthController::class, 'index']);
});


Route::get('/books', function () {
    $books = Book::with('store:id,name')->get();
    return response()->json($books);
});
Route::post('/books', [BookController::class, 'store']);
Route::get('/books/{id}', [BookController::class, 'show']);
Route::put('/books/{id}', [BookController::class, 'update']);
Route::delete('/books/{id}', [BookController::class, 'destroy']);


Route::get('/stores', [StoreController::class, 'index']);
Route::get('/stores/find/{id}', [StoreController::class, 'show']);
Route::post('/stores/registry', [StoreController::class, 'store']);
Route::put('/stores/update/{id}', [StoreController::class, 'update']);
Route::delete('/stores/delete/{id}', [StoreController::class, 'destroy']);
