<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    // Регистрация
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' 			=> 'required|string',
            'email' 		=> 'required|email|unique:users',
            'password' 		=> 'required|string|min:6'
        ]);

        $user = User::create($validated);
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status'    => 'success',
            'data'      => new UserResource($user),
            'token'     => $token
        ]);
    }

    // Вход
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' 	=> 'required|email',
            'password' 	=> 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password))
        {
            return response()->json([
                'message'   => 'Неверные данные'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        
        return response()->json([
            'status'    => 'success',
            'data'      => new UserResource($user),
            'token'     => $token
        ]);
    }
}
