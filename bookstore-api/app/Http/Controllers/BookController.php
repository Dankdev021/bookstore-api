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
        try {
            $request->validate([
                'name' => 'required',
                'isbn' => 'required|numeric',
                'value' => 'required|numeric',
                'store_id' => 'required|exists:stores,id'
            ]);
        
            $existingBook = Book::where('isbn', $request->isbn)->first();
            if ($existingBook) {
                return response()->json(['message' => 'Book with same ISBN already exists'], 409); // 409 Conflict
            }

            $book = Book::create($request->all());
    
            return response()->json($book, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'store not exists'], 500);
        }
    }
    
    public function update(Request $request, $id)
    {
        try{
            $book = Book::findOrFail($id);
    
            $request->validate([
                'name' => 'required',
                'isbn' => 'required|numeric',
                'value' => 'required|numeric',
                'store_id' => 'required|exists:stores,id'
            ]);
        
            $existingBook = Book::where('isbn', $request->isbn)->where('id', '!=', $id)->first();
            if ($existingBook) {
                return response()->json(['message' => 'Book with same ISBN already exists'], 409); // 409 Conflict
            }
    
            $book = Book::findOrFail($id);
            $book->update($request->all());
    
            return response()->json($book);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error'], 500);
        }
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
