<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Deals\DealsController;
use App\Http\Controllers\Api\home\HomeController;
use App\Http\Controllers\Api\appointment\AppointmentController;
use App\Http\Controllers\Api\Plates\PlatesController;
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

Route::post('/login',[AuthController::class,'login'])->middleware('verification');
Route::middleware(['guest:sanctum'])->prefix('auth')->group(function () {

    Route::post('/register',[AuthController::class,'register']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('profile',[\App\Http\Controllers\Api\home\HomeController::class,'profile'])->name('profile');
    Route::post('ads/car',[\App\Http\Controllers\Api\Cars\CarsController::class,'car']);
    Route::get('/show/car/{uuid}',[\App\Http\Controllers\Api\Cars\CarsController::class,'onecar']);
    Route::post('order/appointment',[AppointmentController::class,'addappointment']);
    Route::post('order/appointment/accept',[AppointmentController::class,'accept']);

});

Route::get('home',[\App\Http\Controllers\Api\home\HomeController::class,'home']);
Route::post('verification code',[AuthController::class, 'verification_code']);
Route::post('resend code',[AuthController::class, 'resend_code']);
Route::get('show/cars', [HomeController::class,'lodemor'])->name('cars.lodemor');
Route::controller(UserOrderController::class)->prefix('orders')->name('orders.')->group(function () {
    Route::post('/store', 'store')->name('store');
});
Route::post('plates',[PlatesController::class, 'plates']);
Route::get('plates',[PlatesController::class, 'getplates']);
Route::post('deal',[DealsController::class, 'deal']);
Route::post('deal_code',[DealsController::class, 'deal_code']);
Route::get('deals',[HomeController::class, 'deals']);



