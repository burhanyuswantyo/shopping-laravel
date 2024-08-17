<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate request
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Check user
        $user = User::query()->where('email', $request->email)->first();

        // Check password
        if (!$user || !\Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Email atau password salah',
            ], 422);
        }

        // Remove old token
        $user->tokens()->delete();

        // Create token
        $token = $user->createToken($user->email . '-' . now());

        return response()->json([
            'token' => $token->plainTextToken,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Berhasil logout'
        ]);
    }

    public function register(RegisterRequest $request)
    {
        // Create user
        $user = User::create($request->all());

        if ($user) {
            return response()->json([
                'message' => 'Registrasi berhasil',
                'user' => $user
            ]);
        } else {
            return response()->json([
                'message' => 'Registrasi gagal',
            ], 422);
        }
    }

    public function getUser()
    {
        return response()->json([
            'message' => 'Berhasil mendapatkan data user',
            'data' => auth()->user()
        ]);
    }
}
