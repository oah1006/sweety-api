<?php

use App\Http\Controllers\Attachment\AttachmentController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\Otp\SendOtpController;
use App\Http\Controllers\Auth\Otp\VerifyOtpController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Coupon\CouponController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\DeliveryAddress\CustomerDeliveryAddressController;
use App\Http\Controllers\DeliveryAddress\DeliveryAddressController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Store\StoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Staff\StaffController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('private')->name('private.')->group(function() {
    // Auth in admin system
    Route::prefix('auth')->name('auth.')->group(function() {
        Route::post('/login', [AuthenticationController::class, 'login'])->name('login');
        Route::post('/send-otp', [SendOtpController::class, 'requestOtp'])->name('send-otp');
        Route::post('/verify-otp', [VerifyOtpController::class, 'verifyOtp'])->name('verify-otp');
        Route::post('/forgot-password', [ForgotPasswordController::class, 'forgotPassword'])
            ->name('forgot-password')->middleware('ensureTokenIsValid');
        Route::post('/logout', [AuthenticationController::class, 'logout'])
            ->name('logout')->middleware('auth:sanctum');
        Route::get('profile', [ProfileController::class, 'showProfile'])
            ->name('show-profile')->middleware('auth:sanctum');
        Route::put('profile', [ProfileController::class, 'update'])
            ->name('update-profile')->middleware('auth:sanctum');
        Route::put('change-password', [ChangePasswordController::class, 'changePassword'])
            ->name('change-password')->middleware('auth:sanctum');
    });

    Route::middleware('auth:sanctum')->group(function() {
        Route::apiResource('customers', CustomerController::class);
        Route::apiResource('staff', StaffController::class);
        Route::apiResource('stores', StoreController::class);
        Route::apiResource('categories', CategoryController::class);
        Route::apiResource('products', ProductController::class);
        Route::apiResource('coupons', CouponController::class);
        Route::apiResource('orders', OrderController::class);
        Route::resource('customers.delivery_addresses', CustomerDeliveryAddressController::class);
        Route::post('/attachments/{attachmentable}/{attachmentableId}', [AttachmentController::class, 'store'])->name('store');
        Route::delete('/attachments/{attachment}', [AttachmentController::class, 'detach'])->name('detach');
    });

});
