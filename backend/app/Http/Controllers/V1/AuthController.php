<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Контроллер для авторизации
 */
class AuthController extends Controller
{
    /**
     * Метод для авторизации
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        $user = User::query()->where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $token = JWTAuth::fromUser($user);

        return $this->respondWithToken($token);
    }


    /**
     * Метод для отчистки токена
     */
    public function logout(): JsonResponse
    {
        try {
            JWTAuth::parseToken()->invalidate();
            return response()->json(['message' => 'Successfully logged out']);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to logout',
            ], 400);
        }
    }

    /**
     * Метод для рефреша токена
     */
    public function refresh(): JsonResponse
    {
        try {
            $newToken = JWTAuth::parseToken()->refresh();
            return $this->respondWithToken($newToken);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to refresh token',
            ], 401);
        }
    }

    protected function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'expires_in' => JWTAuth::factory()->getTTL() * 60 * 24 * 30
        ]);
    }
}
