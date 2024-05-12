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
   // Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login/up', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/users', [AuthController::class, 'index'])->middleware('auth:sanctum');
});


Route::get('/books', function () {
    $books = Book::with('store:id,name')->get();
    return response()->json($books);
})->middleware('auth:sanctum');

Route::post('/books', [BookController::class, 'store'])->middleware('auth:sanctum');
Route::get('/books/{id}', [BookController::class, 'show'])->middleware('auth:sanctum');
Route::put('/books/{id}', [BookController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/books/{id}', [BookController::class, 'destroy'])->middleware('auth:sanctum');


Route::get('/stores', [StoreController::class, 'index'])->middleware('auth:sanctum');
Route::get('/stores/find/{id}', [StoreController::class, 'show'])->middleware('auth:sanctum');
Route::post('/stores/registry', [StoreController::class, 'store'])->middleware('auth:sanctum');
Route::put('/stores/update/{id}', [StoreController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/stores/delete/{id}', [StoreController::class, 'destroy'])->middleware('auth:sanctum');
