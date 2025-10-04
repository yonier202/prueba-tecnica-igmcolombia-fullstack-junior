<?php

namespace App\Modules\Auth\Services;

use App\Modules\Auth\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class AuthService
{
    public function login(array $credentials): JsonResponse
    {
        try {
            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Credenciales incorrectas'
                ], 401);
            }

            $user = Auth::user();

            return response()->json([
                'status' => 'success',
                'token'  => $user->createToken('Api Token')->plainTextToken,
                'data'   => $user
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function register(array $data): JsonResponse
    {
        try {
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $user->assignRole(2);

            return response()->json([
                'status' => 'success',
                'token'  => $user->createToken('Api Token')->plainTextToken,
                'data'   => $user,
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
