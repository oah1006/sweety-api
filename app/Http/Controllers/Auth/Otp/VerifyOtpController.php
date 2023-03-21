<?php

namespace App\Http\Controllers\Auth\Otp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Otp\VerifyOtpRequest;
use App\Models\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VerifyOtpController extends Controller
{
    public function verifyOtp(VerifyOtpRequest $request) {
        $data = $request->validated();

        $otp = Otp::where('email', $request->email)->first();

        if ($otp && Hash::check($data['otp'], $otp->token) && $otp->expires_at > now()) {
            return response()->json([
                'token' => $otp->token
            ], 200);
        }

        return response()->json([
            'error' => 'OTP của bạn không hợp lệ! Vui lòng nhập mã OTP khác được gửi qua email!'
        ], 400);
    }
}