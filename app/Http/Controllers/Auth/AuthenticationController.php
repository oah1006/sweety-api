<?php

namespace App\Http\Controllers\Auth;

use App\Models\Staff;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticationController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        /** @var Staff $staff */
        $staff = Staff::where('email', $credentials['email'])->first();

        if ($staff && Hash::check($credentials['password'], $staff->password)) {
            $token = $staff->createToken('apitoken');

            return response()->json([
                'data' => [
                    'access_token' => $token->plainTextToken,
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
