<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\LoginUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;


class AuthenticationController extends Controller
{
    public function login(LoginUserRequest $request)
    {
        $credentials = $request->validated();

        /** @var User $user */
        $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            $token = $user->createToken('api-token');

            return response()->json([
                'data' => [
                    'token' => $token->plainTextToken,
                    'expires_at' => $token->accessToken->expires_at,
                ]
            ], 200);
        }

        return response()->json([
            'message' => 'Thông tin đăng nhập không chính xác!',
        ], 401);
    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();

        return response()->noContent();
    }
}
