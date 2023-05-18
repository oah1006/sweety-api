<?php

namespace App\Http\Controllers\admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AuthenticationController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        /** @var User $user */
        $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password) && $user->profile_type == 'staff') {
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
