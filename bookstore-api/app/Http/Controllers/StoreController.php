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

        return response()->json([
            'message' => 'Store successfully create.'
        ], 200);
    }

    public function index()
    {
        $stores = Store::all();
        return response()->json($stores);
    }

    public function show($id)
    {
        $store = Store::find($id);

        if (!$store) {
            return response()->json(['message' => 'Store not found'], 404);
        }

        return response()->json($store);
    }

    public function update(Request $request, $id)
    {
        $store = Store::find($id);

        if (!$store) {
            return response()->json(['message' => 'Store not found'], 404);
        }

        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'active' => 'required|boolean',
        ]);
    
        $store->update($request->all());
        return response()->json(['message' => 'Store successfully updated'], 200);
    }

    public function destroy($id)
    {
        $store = Store::find($id);

        if (!$store) {
            return response()->json(['message' => 'Store not found'], 404);
        }

        $store->delete();
        return response()->json(['message' => 'Store successfully deleted'], 200);
    }
}
