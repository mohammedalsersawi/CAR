<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\userOrder\UserOrderController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['guest:sanctum'])->prefix('auth')->group(function () {
    Route::post('/login',[AuthController::class,'login']);
    Route::post('/register',[AuthController::class,'register']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

});

Route::post('verification code',[AuthController::class, 'verification_code']);
Route::post('resend code',[AuthController::class, 'resend_code']);


Route::controller(UserOrderController::class)->prefix('orders')->name('orders.')->group(function () {
    Route::post('/store', 'store')->name('store');
});
