<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function home()
    {
        return response()->json(['message' => 'API Laravel 8 Unauthorized - Log in'], 200);
    }

    public function index()
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
    
        try {
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                $token = $user->createToken('API Token')->plainTextToken;

                return response()->json(['token' => $token, 'message' => 'User registered successfully'], 201);
            } else {
                return response()->json(['message' => 'Email already registered'], 400);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $user->tokens()->delete();
            $token = $user->createToken('API Token')->plainTextToken;
    
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function logout(Request $request)
    {
        if (!$request->user()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        if (!$request->user()->currentAccessToken() || empty($request->user()->currentAccessToken()->token)) {
            return response()->json(['error' => 'User needs to be logged in'], 403);
        }
        $deleted = $request->user()->currentAccessToken()->delete();
        if ($deleted) {
            return response()->json(['message' => 'Logged out successfully'], 200);
        } else {
            return response()->json(['error' => 'Failed to logout'], 500);
        }
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
    
        $user->delete();
        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
