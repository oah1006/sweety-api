<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function forgotPassword(ForgotPasswordRequest $request) {
        $data = $request->validated();

        $user = User::where('email', $data['email'])->update([
            'password' => Hash::make($request->new_password)
        ]);

        if ($request->otp) {
            $request->otp->delete();
        }

        return response()->json([
            'user' => $user,
            'message' => 'thanh cong'
        ], 201);
    }
}
