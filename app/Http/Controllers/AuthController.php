<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4',
        ], [
            'email.unique' => 'Este e-mail já está em uso.',
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
    
            return response()->json([
                'message' => 'User registered successfully!'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to register user'
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            $user->tokens->each(function (PersonalAccessToken $token) {
                $token->delete();
            });

            $token = $user->createToken('token_name');

            return response(['token' => $token->plainTextToken], 200);
        }

        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens->each(function (PersonalAccessToken $token) {
            $token->delete();
        });

        Auth::logout();

        return response()->json([
            'message' => 'User logged out successfully'
        ], 200);
    }
}
