<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return response()->json($books);
    }
    
    public function show($id)
    {
        $book = Book::findOrFail($id);
        return response()->json($book);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'isbn' => 'required|numeric',
            'value' => 'required|numeric',
            'store_id' => 'required|exists:stores,id'
        ]);
    
        $book = Book::create($request->all());
    
        return response()->json($book, 201);
    }
    
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);
    
        $request->validate([
            'name' => 'required',
            'isbn' => 'required|numeric',
            'value' => 'required|numeric',
            'store_id' => 'required|exists:stores,id'
        ]);
    
        $book->update($request->all());
    
        return response()->json($book);
    }
    
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
    
        return response()->json([
            'message' => 'Book deleted successfully.'
        ], 200);
    }
}
