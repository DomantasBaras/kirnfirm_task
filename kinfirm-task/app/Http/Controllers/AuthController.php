<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Validator;
class AuthController extends Controller
{
    // Registration method
    public function register(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8', // Ensure password confirmation is checked
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Generate a token for the user
        $token = $user->createToken('token-name', ['server:update'])->plainTextToken;

        return response()->json([
            'token' => $token,
        ]);
    }

    // Login method
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!auth()->attempt($validated)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = auth()->user();
        return response()->json(['token' =>  $user->createToken('token-name', ['server:update'])->plainTextToken]);
    }

    public function logout(Request $request)
    {
        // Ensure the user is authenticated
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Revoke all tokens for the authenticated user
        $user->tokens()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }
}

