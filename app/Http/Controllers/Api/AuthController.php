<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8'
        ]);

        $user = User::whereEmail($validated['email'])->first();

        if (is_null($user)) {
            abort(404, 'User does not exists.');
        }

        $user->tokens()->delete();

        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email or password is invalid.']
            ]);
        }

        $token = $user->createToken($validated['email'])->plainTextToken;

        return response()->json([
            'message' => 'Successfully logged in',
            'token' => $token
        ]);
    }

    public function logout()
    {
        $user = auth()->user();
        $user->tokens()->delete();

        return response()->json([
            'message' => 'Succesfully logged out'
        ], 200);
    }
}
