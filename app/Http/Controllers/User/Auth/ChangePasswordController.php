<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\ChangePasswordRequest;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function changePassword(ChangePasswordRequest $request) {
        $user = $request->user();

        $credentials = $request->validated();

        if (Hash::check($credentials['old_password'], $user->password)) {
            $user->update([
                'password' => Hash::make($credentials['password'])
            ]);

            return response()->json([
                'message' => 'Cập nhật mật khẩu thành công'
            ]);
        }
    }
}
