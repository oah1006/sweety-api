<?php

namespace App\Http\Controllers\admin\Auth\Otp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\Otp\SendOtpRequest;
use App\Mail\SendMail;
use App\Models\Otp;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class SendOtpController extends Controller
{
    public function requestOtp(SendOtpRequest $request) {
        $otp = fake()->randomNumber(6, true);

        $email = $request->get('email');

        Otp::where('email', $email)->delete();

        $insertOtp = Otp::insert([
            'email' => $email,
            'token' => Hash::make($otp),
            'expires_at' => Carbon::now()->addMinutes(1),
        ]);

        Mail::to($request->email)->send(new SendMail($otp, $email));

        return response()->json([
            'otp' => $insertOtp,
        ], 201);
    }
}
