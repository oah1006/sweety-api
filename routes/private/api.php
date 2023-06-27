<?php

use App\Http\Controllers\admin\Attachment\AttachmentController;
use App\Http\Controllers\admin\Auth\AuthenticationController;
use App\Http\Controllers\admin\Auth\ChangePasswordController;
use App\Http\Controllers\admin\Auth\ForgotPasswordController;
use App\Http\Controllers\admin\Auth\Otp\SendOtpController;
use App\Http\Controllers\admin\Auth\Otp\VerifyOtpController;
use App\Http\Controllers\admin\Auth\ProfileController;
use App\Http\Controllers\Admin\Category\CategoryController;
use App\Http\Controllers\Admin\Coupon\CouponController;
use App\Http\Controllers\Admin\Customer\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DeliveryAddress\DeliveryAddressController;
use App\Http\Controllers\Admin\Order\OrderController;
use App\Http\Controllers\Admin\Product\ProductController;
use App\Http\Controllers\Admin\ProductVariant\ProductVariantController;
use App\Http\Controllers\Admin\Province\DistrictController;
use App\Http\Controllers\Admin\Province\ProvinceController;
use App\Http\Controllers\Admin\Province\WardController;
use App\Http\Controllers\Admin\Staff\StaffController;
use App\Http\Controllers\Admin\Store\StoreController;
use App\Http\Controllers\Admin\Topping\ToppingController;
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

Route::prefix('private')->name('private.')->group(function() {
    // Auth in Admin system
    Route::prefix('auth')->name('auth.')->group(function() {
        // Admin
        Route::post('/login', [AuthenticationController::class, 'login'])->name('login');
        Route::post('/send-otp', [SendOtpController::class, 'requestOtp'])->name('send-otp');
        Route::post('/verify-otp', [VerifyOtpController::class, 'verifyOtp'])->name('verify-otp');
        Route::post('/forgot-password', [ForgotPasswordController::class, 'forgotPassword'])
            ->name('forgot-password')->middleware('ensureTokenIsValid');
        Route::post('/logout', [AuthenticationController::class, 'logout'])
            ->name('logout')->middleware('auth:sanctum');
        Route::get('profile', [ProfileController::class, 'showProfile'])
            ->name('show-profile')->middleware(['auth:sanctum', 'ensureStaffIsValid']);
        Route::put('profile', [ProfileController::class, 'update'])
            ->name('update-profile')->middleware(['auth:sanctum', 'ensureStaffIsValid']);
        Route::put('change-password', [ChangePasswordController::class, 'changePassword'])
            ->name('change-password')->middleware(['auth:sanctum', 'ensureStaffIsValid']);
    });

    Route::middleware(['auth:sanctum', 'ensureStaffIsValid'])->group(function() {
        Route::apiResource('customers', CustomerController::class);
        Route::apiResource('staff', StaffController::class);
        Route::apiResource('stores', StoreController::class);
        Route::apiResource('categories', CategoryController::class);
        Route::apiResource('products', ProductController::class);
        Route::apiResource('coupons', CouponController::class);
        Route::apiResource('orders', OrderController::class);
        Route::apiResource('toppings', ToppingController::class);
        Route::apiResource('productVariants', ProductVariantController::class);
        Route::apiResource('delivery-addresses', DeliveryAddressController::class);

        Route::get('/dashboard/best-seller-product', [DashboardController::class, 'indexBestSeller'])->name('index-best-seller');
        Route::get('/dashboard/compare-revenue', [DashboardController::class, 'compareRevenue'])->name('compare-revenue');
        Route::get('/dashboard/total-product', [DashboardController::class, 'totalProduct'])->name('total-product');
        Route::get('/dashboard/total-order', [DashboardController::class, 'totalOrder'])->name('total-order');
        Route::get('/dashboard/calculate-revenue-by-dates', [DashboardController::class, 'calculateRevenueByDates'])->name('calculate-revenue-by-dates');
        Route::get('/dashboard/get-product-by-dates', [DashboardController::class, 'getProductByDates'])->name('get-product-by-dates');


        Route::put('/orders/update-status-accepted/{order}', [OrderController::class, 'updateStatusAccepted'])->name('update-accepted-status');
        Route::put('/orders/update-status-preparing/{order}', [OrderController::class, 'updateStatusPreparing'])->name('update-preparing-status');
        Route::put('/orders/update-status-prepared/{order}', [OrderController::class, 'updateStatusPrepared'])->name('update-prepared-status');
        Route::put('/orders/update-status-delivering/{order}', [OrderController::class, 'updateStatusDelivering'])->name('update-delivering-status');
        Route::put('/orders/update-status-succeed/{order}', [OrderController::class, 'updateStatusSucceed'])->name('update-succeed-status');
        Route::put('/orders/update-status-failed/{order}', [OrderController::class, 'updateStatusFailed'])->name('update-failed-status');

        Route::get('/provinces', [ProvinceController::class, 'index'])->name('index');
        Route::get('/districts/{provinceCode}', [DistrictController::class, 'index'])->name('index');
        Route::get('/wards/{districtCode}', [WardController::class, 'index'])->name('index');

        Route::get('/calculation-routes', [DeliveryAddressController::class, 'calculationRoute'])->name('calculation-routes');
        Route::get('/get-coordinates/', [DeliveryAddressController::class, 'getCoordinates'])->name('get-coordinates');

        Route::post('/attachments/{attachmentable}/{attachmentableId}', [AttachmentController::class, 'store'])->name('store');
        Route::delete('/attachments/{attachment}', [AttachmentController::class, 'detach'])->name('detach');
    });

});

Route::prefix('public')->name('public.')->group(function() {
    Route::middleware('auth:sanctum')->group(function() {
        Route::apiResource('orders', OrderController::class);
    });
});
