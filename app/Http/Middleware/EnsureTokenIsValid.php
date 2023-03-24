<?php

namespace App\Http\Middleware;

use App\Models\Otp;
use Closure;
use Illuminate\Http\Request;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $otp = Otp::where('token', $request->header('token'))->first();

        if (!$otp || $otp->expires_at < now()) {
            return response()->json([
                'message' => 'OTP của bạn đã hết thời gian hiệu lực'
            ], 400);
        }

        if ($otp && $otp->expires_at < now()) $otp->delete();

        $request->merge([
            "otp" => $otp
        ], 201);

        return $next($request);
    }
}
