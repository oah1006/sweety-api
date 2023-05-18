<?php

namespace App\Http\Controllers\admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\ForgotPasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function forgotPassword(ForgotPasswordRequest $request) {
        $data = $request->validated();

        $user = User::where('email', $data['email'])->update([
            'password' => Hash::make($request->new_password)
        ]);

        $request->otp->delete();

        return response()->json([
            'user' => $user,
            'message' => 'Thay đổi mật khẩu thành công'
        ], 201);
    }
}
