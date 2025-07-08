<?php

// Intended Path: app/Http/Controllers/API/AuthController.php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\User; // Assuming your User model is in App\Models
// use App\Http\Resources\UserResource; // Optional

class AuthController extends Controller
{
    /**
     * Handle a login request to the application.
     * POST /api/login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // $token = $user->createToken('authToken')->plainTextToken; // For Sanctum
            // For Passport, it might be $user->createToken('authToken')->accessToken;

            // Placeholder token for now
            $token = 'mock-api-token-from-laravel-login-' . $user->id . '-' . time();


            return response()->json([
                'message' => 'Login successful',
                'user' => $user, // or new UserResource($user)
                'token' => $token,
                'token_type' => 'Bearer',
            ]);
        }

        return response()->json([
            'message' => 'The provided credentials do not match our records.',
        ], 401); // Unauthorized
    }

    /**
     * Handle a registration request for the application.
     * POST /api/register
     */
    public function register(Request $request)
    {
        // $validatedData = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'password' => ['required', 'confirmed', Password::defaults()], // Password::defaults() for strong password rules
        //     'role' => 'required|string|in:user,vendor', // Example roles
        // ]);

        // $user = User::create([
        //     'name' => $validatedData['name'],
        //     'email' => $validatedData['email'],
        //     'password' => Hash::make($validatedData['password']),
        //     'role' => $validatedData['role'], // Ensure your User model has a 'role' attribute or similar
        // ]);

        // // Optionally, log the user in immediately and issue a token
        // // Auth::login($user);
        // // $token = $user->createToken('authToken')->plainTextToken;

        // return response()->json([
        //     'message' => 'Registration successful. Please login.', // Or return user and token if auto-logging in
        //     'user' => $user, // or new UserResource($user)
        //     // 'token' => $token, // if auto-login
        //     // 'token_type' => 'Bearer', // if auto-login
        // ], 201);

        return response()->json(['message' => 'Placeholder for user registration.'], 501);
    }

    /**
     * Log the user out of the application.
     * POST /api/logout (Protected Route)
     */
    public function logout(Request $request)
    {
        // For Sanctum:
        // auth()->user()->tokens()->delete(); // Revoke all tokens for the user
        // Or $request->user()->currentAccessToken()->delete(); // Revoke only the current token

        // For Passport, it's similar but might depend on specific setup.

        Auth::guard('web')->logout(); // If also using web guard for any reason

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Get the authenticated User.
     * GET /api/user (Protected Route)
     */
    public function user(Request $request)
    {
        // return new UserResource($request->user());
        return response()->json($request->user());
    }
}
