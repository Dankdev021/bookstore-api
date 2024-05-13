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

Route::get('/login', [AuthController::class, 'home'])->name('login');

Route::prefix('users')->group(function () {
    Route::post('/login/up', [AuthController::class, 'login'])->name('loginUp');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/users', [AuthController::class, 'index'])->middleware('auth:sanctum');
    Route::delete('/delete/{id}', [AuthController::class, 'destroy']);
});


Route::prefix('books')->group(function () {
    Route::get('/list', function () {
        $books = Book::with('store:id,name')->get();
        return response()->json($books);
    })->middleware('auth:sanctum');
    
    Route::get('/{id}', function ($id) {
        $book = Book::with('store:id,name')->find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }
        return response()->json($book);
    })->middleware('auth:sanctum');
    Route::post('/register', [BookController::class, 'store'])->middleware('auth:sanctum');
    Route::put('/update/{id}', [BookController::class, 'update'])->middleware('auth:sanctum');
    Route::delete('/delete/{id}', [BookController::class, 'destroy'])->middleware('auth:sanctum');
});


Route::prefix('stores')->group(function () {
    Route::get('/list', [StoreController::class, 'index'])->middleware('auth:sanctum');
    Route::get('/find/{id}', [StoreController::class, 'show'])->middleware('auth:sanctum');
    Route::post('/register', [StoreController::class, 'store'])->middleware('auth:sanctum');
    Route::put('/update/{id}', [StoreController::class, 'update'])->middleware('auth:sanctum');
    Route::delete('/delete/{id}', [StoreController::class, 'destroy'])->middleware('auth:sanctum');
});

