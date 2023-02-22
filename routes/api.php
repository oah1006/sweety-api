<?php

use App\Http\Controllers\Customer\CustomerController;
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
        Route::post('/logout', [AuthenticationController::class, 'logout'])
            ->name('logout')->middleware('auth:sanctum');
    });

    Route::middleware('auth:sanctum')->group(function() {
        Route::apiResource('customers', CustomerController::class);
        Route::apiResource('staff', StaffController::class);
    });

});
