<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Car\ModelController;
use App\Http\Controllers\Admin\brand\BrandController;
use App\Http\Controllers\Admin\engines\EngineController;
use App\Http\Controllers\Admin\engines\EnginesController;
use App\Http\Controllers\Admin\fuel_type\FuelTypeController;
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
            Route::GET('/model/edit/{id?}', 'edit')->name('model.edit');
            Route::delete('/model/delete/{id?}', 'destroy')->name('model.delete');
        });
        Route::controller(EngineController::class)->group(function () {
            Route::get('/engines', 'index')->name('engines');
            Route::post('/engines/store', 'store')->name('engines.store');
            Route::GET('/engines/edit/{id?}', 'edit')->name('engines.edit');
            Route::delete('/engines/delete/{id?}', 'destroy')->name('engines.delete');
        });
        Route::controller(FuelTypeController::class)->group(function () {
            Route::get('/fuel/type', 'index')->name('fuel_type');
            Route::post('/fuel/type/store', 'store')->name('fuel_type.store');
            Route::GET('/fuel/type/edit/{id?}', 'edit')->name('fuel_type.edit');
            Route::delete('/fuel/type/delete/{id?}', 'destroy')->name('fuel_type.delete');
        });
        Route::controller(BrandController::class)->group(function () {
            Route::get('/brand', 'index')->name('brand');
            Route::post('/brand/store', 'store')->name('brand.store');
            Route::GET('/brand/edit/{id?}', 'edit')->name('brand.edit');
            Route::delete('/brand/delete/{id?}', 'destroy')->name('brand.delete');
        });
        Route::resource('brand',BrandController::class)->only(['index','store','destroy']);
    }
);


