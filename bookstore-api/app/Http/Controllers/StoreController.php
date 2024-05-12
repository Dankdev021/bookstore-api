<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;

class StoreController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'active' => 'required|boolean',
        ]);

        $store = Store::create($request->all());

        return response()->json($store, 201);
    }

    public function index()
    {
        $stores = Store::all();
        return response()->json($stores);
    }

    public function show($id)
    {
        $store = Store::findOrFail($id);
        return response()->json($store);
    }

    public function update(Request $request, $id)
    {
        $store = Store::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'active' => 'required|boolean',
        ]);

        $store->update($request->all());

        return response()->json($store);
    }

    public function destroy($id)
    {
        $store = Store::findOrFail($id);
        $store->delete();
    
        return response()->json([
            'message' => 'Loja excluída com sucesso.'
        ], 200);
    }
}
