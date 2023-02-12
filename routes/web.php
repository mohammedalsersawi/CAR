<?php


use App\Http\Controllers\Admin\Car\BrandController;
use App\Http\Controllers\Admin\Car\ColorController;
use App\Http\Controllers\Admin\Car\EngineController;
use App\Http\Controllers\Admin\Car\FuelTypeController;
use App\Http\Controllers\Admin\Car\RoomController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Car\ModelController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        Route::prefix('admin')->middleware('auth')->group(function () {
            Route::view('index', 'admin.part.app');
        });

        Route::controller(ModelController::class)->group(function () {
            Route::get('/model', 'index')->name('model');
            Route::post('/model/store', 'store')->name('model.store');
            Route::GET('/model/edit/{id?}', 'edit')->name('model.edit');
            Route::delete('/model/delete/{id?}', 'destroy')->name('model.delete');
            Route::get('model/getData', 'getData')->name('model.getData');
        });
        Route::controller(EngineController::class)->group(function () {
            Route::get('/engines', 'index')->name('engines');
            Route::post('/engines/store', 'store')->name('engines.store');
            Route::GET('/engines/edit/{id?}', 'edit')->name('engines.edit');
            Route::delete('/engines/delete/{id?}', 'destroy')->name('engines.delete');
            Route::get('engines/getData', 'getData')->name('engines.getData');
        });
        Route::controller(FuelTypeController::class)->group(function () {
            Route::get('/fuel/type', 'index')->name('fuel_type');
            Route::post('/fuel/type/store', 'store')->name('fuel_type.store');
            Route::GET('/fuel/type/edit/{id?}', 'edit')->name('fuel_type.edit');
            Route::delete('/fuel/type/delete/{id?}', 'destroy')->name('fuel_type.delete');
            Route::GET('fuel/type/getData', 'getData')->name('fuel_type.getData');
        });
        Route::controller(BrandController::class)->group(function () {
            Route::get('/brand', 'index')->name('brand');
            Route::post('/brand/store', 'store')->name('brand.store');
            Route::GET('/brand/edit/{id?}', 'edit')->name('brand.edit');
            Route::delete('/brand/delete/{id?}', 'destroy')->name('brand.delete');
            Route::get('brand/getData', 'getData')->name('brand.getData');
        });
        Route::resource('room',RoomController::class)->except(['create','update']);
        Route::resource('color',ColorController::class)->except(['create','show','update']);
    }
);


