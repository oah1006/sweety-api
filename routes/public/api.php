<?php

use App\Http\Controllers\User\Auth\ChangePasswordController;
use App\Http\Controllers\User\Auth\ForgotPasswordController;
use App\Http\Controllers\User\Auth\Otp\SendOtpController;
use App\Http\Controllers\User\Auth\Otp\VerifyOtpController;
use App\Http\Controllers\User\Cart\CartController;
use App\Http\Controllers\User\Cart\CartItemController;
use App\Http\Controllers\User\Category\CategoryController;
use App\Http\Controllers\User\Coupon\CouponController;
use App\Http\Controllers\User\DeliveryAddress\DeliveryAddressController;
use App\Http\Controllers\User\Order\OrderController;
use App\Http\Controllers\User\Auth\AuthenticationController;
use App\Http\Controllers\User\Auth\ProfileController;
use App\Http\Controllers\User\Product\ProductController;
use App\Http\Controllers\User\Province\DistrictController;
use App\Http\Controllers\User\Province\ProvinceController;
use App\Http\Controllers\User\Province\WardController;

use App\Http\Controllers\User\Store\StoreController;
use App\Http\Controllers\User\Topping\ToppingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




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

Route::prefix('public')->name('public.')->group(function() {
    Route::prefix('auth')->name('auth.')->group(function() {
        Route::post('/login', [AuthenticationController::class, 'login'])
            ->name('login');
        Route::post('/register', [AuthenticationController::class, 'register'])
            ->name('register');
        Route::post('/logout', [AuthenticationController::class, 'logout'])
            ->name('logout')->middleware('auth:sanctum');

        Route::put('change-password', [ChangePasswordController::class, 'changePassword'])
            ->name('change-password')->middleware(['auth:sanctum', 'ensureCustomerIsValid']);


        Route::post('/send-otp', [SendOtpController::class, 'requestOtp'])->name('send-otp');
        Route::post('/verify-otp', [VerifyOtpController::class, 'verifyOtp'])->name('verify-otp');
        Route::post('/forgot-password', [ForgotPasswordController::class, 'forgotPassword'])
            ->name('forgot-password')->middleware('ensureTokenIsValid');

        Route::get('/profile', [ProfileController::class, 'showProfile'])
            ->name('show-profile')->middleware(['auth:sanctum', 'ensureCustomerIsValid']);
        Route::put('profile', [ProfileController::class, 'update'])
            ->name('update-profile')->middleware(['auth:sanctum', 'ensureCustomerIsValid']);
    });

    Route::get('/products/index-best-seller/', [ProductController::class, 'indexBestSeller'])->name('index-best-seller');
    Route::get('/products/index-related-product/{category}/{product}', [ProductController::class, 'indexRelatedProduct'])->name('index-related-product');

    Route::apiResource('coupons', CouponController::class);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('toppings', ToppingController::class);



    Route::middleware(['auth:sanctum', 'ensureCustomerIsValid'])->group(function() {
        Route::apiResource('orders', OrderController::class);
        Route::apiResource('delivery-addresses', DeliveryAddressController::class);
        Route::apiResource('carts', CartController::class);
        Route::apiResource('stores', StoreController::class);

        Route::delete('/cart-items/{cartItem}', [CartItemController::class, 'minusQty'])->name('minusQty');
        Route::put('/cart-items/{cartItem}', [CartItemController::class, 'addQty'])->name('addQty');

        Route::put('/delivery-addresses/change-is-default/{address}', [DeliveryAddressController::class, 'changeIsDefault'])->name('change-is-default');
        Route::post('/delivery-address/choose-my-delivery-address/{address}', [DeliveryAddressController::class, 'chooseMyDeliveryAddressOrder'])->name('choose-my-delivery-address');

        Route::post('/coupons/apply-coupon/{coupon}', [CouponController::class, 'applyCoupon']);
        Route::post('/coupons/remove-coupon', [CouponController::class, 'removeCoupon']);

        Route::put('/orders/update-status-canceled/{order}', [OrderController::class, 'updateStatusCanceled'])
            ->name('update-canceled-status');


        Route::get('/provinces', [ProvinceController::class, 'index'])->name('index');
        Route::get('/districts/{provinceCode}', [DistrictController::class, 'index'])->name('index');
        Route::get('/wards/{districtCode}', [WardController::class, 'index'])->name('index');

        Route::get('/get-coordinates/', [DeliveryAddressController::class, 'getCoordinates'])->name('get-coordinates');
    });
});
