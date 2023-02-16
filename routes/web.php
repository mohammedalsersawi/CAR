<?php


use App\Http\Controllers\Admin\Car\BrandController;
use App\Http\Controllers\Admin\Car\ColorController;
use App\Http\Controllers\Admin\Car\EngineController;
use App\Http\Controllers\Admin\Car\FuelTypeController;
use App\Http\Controllers\Admin\Car\RoomController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Car\ModelController;
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
        Route::controller(ModelController::class)->group(function () {
            Route::get('/model', 'index')->name('model');
            Route::post('/model/store', 'store')->name('model.store');
            Route::post('/model/update', 'update')->name('model.update');
            Route::delete('/model{id?}', 'destroy')->name('model.delete');
            Route::get('model/getData', 'getData')->name('model.getData');
        });
        Route::controller(EngineController::class)->group(function () {
            Route::get('/engines', 'index')->name('engines');
            Route::post('/engines/store', 'store')->name('engines.store');
            Route::post('/engines/update', 'update')->name('engines.update');
            Route::delete('/engines/{id?}', 'destroy')->name('engines.delete');
            Route::get('engines/getData', 'getData')->name('engines.getData');
        });
        Route::controller(FuelTypeController::class)->group(function () {
            Route::get('/fuel/type', 'index')->name('fuelType');
            Route::post('/fuel/type/store', 'store')->name('fuelType.store');
            Route::post('/fuel/type/update', 'update')->name('fuelType.update');
            Route::delete('/fuel/type/{id}', 'destroy')->name('fuelType.delete');
            Route::GET('fuel/type/getData', 'getData')->name('fuelType.getData');
        });
        Route::controller(BrandController::class)->group(function () {
            Route::get('/brand', 'index')->name('brand');
            Route::post('/brand/store', 'store')->name('brand.store');
            Route::post('/brand/update', 'update')->name('brand.update');
            Route::delete('/brand/{id?}', 'destroy')->name('brand.delete');
            Route::get('brand/getData', 'getData')->name('brand.getData');
        });
        Route::controller(RoomController::class)->group(function () {
            Route::get('/room', 'index')->name('room.index');
            Route::post('/room/store', 'store')->name('room.store');
            Route::post('/room/update', 'update')->name('room.update');
            Route::delete('/room/{id?}', 'destroy')->name('room.delete');
            Route::get('room/getData', 'getData')->name('room.getData');
        });
        Route::controller(ColorController::class)->group(function () {
            Route::get('/color', 'index')->name('color.index');
            Route::post('/color/store', 'store')->name('color.store');
            Route::post('/color/update', 'update')->name('color.update');
            Route::delete('/color/{id?}', 'destroy')->name('color.delete');
            Route::get('color/getData', 'getData')->name('color.getData');
        });

    }
);


