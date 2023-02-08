<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\Staff;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\Auth\LoginRequest;

class LoginController extends Controller
{
    public function login(LoginRequest $request) {
        $credentials = $request->validated();

        $staff = Staff::where('email', $credentials['email'])->first();

        if ($staff && Hash::check($credentials['password'], $staff->password)) {
            $token = $staff->createToken('apitoken');

            return response()->json([
                'staff' => $staff,
                'token' => $token->plainTextToken,
            ], 200); 
        }

        return response()->json([
            'message' => 'Thông tin đăng nhập không chính xác!',
        ], 401);
    }
}
