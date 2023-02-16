<?php

use App\Http\Controllers\Admin\Car\area\AreaControllerr;
use App\Http\Controllers\Admin\Car\Brand\BrandController;
use App\Http\Controllers\Admin\Car\City\CityController;
use App\Http\Controllers\Admin\Car\Color\ColorController;
use App\Http\Controllers\Admin\Car\country\CountryController;
use App\Http\Controllers\Admin\Car\Engine\EngineController;
use App\Http\Controllers\Admin\Car\FulType\FuelTypeController;
use App\Http\Controllers\Admin\Car\Model\ModelController;
use App\Http\Controllers\Admin\Car\RoomController;
use Illuminate\Support\Facades\Route;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


Route::prefix('/test')->group(function () {
    Route::view('/', 'welcome');
});

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        Route::prefix('admin')->middleware('auth')->group(function () {
            Route::view('/', 'admin.part.app');
        });
        Route::controller(ModelController::class)->name('model.')->prefix('model')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
            Route::post('/update', 'update')->name('update');
            Route::delete('/{id?}', 'destroy')->name('delete');
            Route::get('/getData', 'getData')->name('getData');
        });
        Route::controller(EngineController::class)->prefix('engines')->name('engines.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
            Route::post('/update', 'update')->name('update');
            Route::delete('/{id?}', 'destroy')->name('delete');
            Route::get('/getData', 'getData')->name('getData');
        });
        Route::controller(FuelTypeController::class)->prefix('fuel/type')->name('fuelType.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
            Route::post('//update', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('delete');
            Route::GET('/getData', 'getData')->name('getData');
        });
        Route::controller(BrandController::class)->prefix('brand')->name('brand.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
            Route::post('/update', 'update')->name('update');
            Route::delete('/{id?}', 'destroy')->name('delete');
            Route::get('/getData', 'getData')->name('getData');
        });
        Route::controller(RoomController::class)->group(function () {
            Route::get('/room', 'index')->name('room.index');
            Route::post('/room/store', 'store')->name('room.store');
            Route::post('/room/update', 'update')->name('room.update');
            Route::delete('/room/{id?}', 'destroy')->name('room.delete');
            Route::get('room/getData', 'getData')->name('room.getData');
        });
        Route::controller(ColorController::class)->prefix('color')->name('color.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
            Route::post('/update', 'update')->name('update');
            Route::delete('/{id?}', 'destroy')->name('delete');
            Route::get('/getData', 'getData')->name('getData');
        });
        Route::controller(CityController::class)->prefix('city')->name('city.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
            Route::post('/update', 'update')->name('update');
            Route::delete('/{id?}', 'destroy')->name('delete');
            Route::get('/getData', 'getData')->name('getData');
        });
        Route::controller(CountryController::class)->prefix('country')->name('country.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
            Route::post('/update', 'update')->name('update');
            Route::delete('/{id?}', 'destroy')->name('delete');
            Route::get('/getData', 'getData')->name('getData');
        });
        Route::controller(AreaControllerr::class)->prefix('area')->name('area.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
            Route::post('/update', 'update')->name('update');
            Route::delete('/{id?}', 'destroy')->name('delete');
            Route::get('/getData', 'getData')->name('getData');
        });

    }
);


