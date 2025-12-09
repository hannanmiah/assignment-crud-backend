<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        // Login the user
        if (!auth()->attempt($request->only('email', 'password'))) return response()->json([
            'message' => 'Invalid Credentials'
        ], 401);

        // Return a JWT token for the authenticated user

        $token = auth()->user()->createToken('api')->plainTextToken;

        return response()->json([
            'token' => $token
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Return a JWT token for the new user
        return response()->json([
            'token' => $user->createToken('api')->plainTextToken,
        ],201);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        return response()->noContent();
    }
}