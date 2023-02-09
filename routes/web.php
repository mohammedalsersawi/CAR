<?php

use App\Http\Controllers\Admin\ModelController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        Route::prefix('admin')->middleware('auth')->group(function () {
            Route::view('index', 'admin.pages.indexCar');
        });

        Route::controller(ModelController::class)->group(function () {
            Route::get('/model', 'index')->name('model');
            Route::post('/model/store', 'store')->name('model.store');
        });
    }
);


