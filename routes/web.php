<?php

use App\Http\Controllers\Admin\Ads\AdsCarController;
use App\Http\Controllers\Admin\Car\area\AreaControllerr;
use App\Http\Controllers\Admin\Car\Brand\BrandController;
use App\Http\Controllers\Admin\Car\City\CityController;
use App\Http\Controllers\Admin\Car\Color\ColorController;
use App\Http\Controllers\Admin\Car\country\CountryController;
use App\Http\Controllers\Admin\Car\Engine\EngineController;
use App\Http\Controllers\Admin\Car\FulType\FuelTypeController;
use App\Http\Controllers\Admin\Car\Model\ModelController;
use App\Http\Controllers\Admin\Car\Transmission\TransmissionController;
use App\Http\Controllers\Admin\DataController;
use App\Http\Controllers\Admin\Deals\DealsController;
use App\Http\Controllers\Admin\order\UserOrderController;
use App\Http\Controllers\Admin\Setting\SettingController;
use App\Http\Controllers\Admin\UserTyue\TypeController;
use App\Http\Controllers\Admin\UserTyue\UserTypeController;
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
        Route::controller(ColorController::class)->prefix('color')->name('color.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
            Route::post('/update', 'update')->name('update');
            Route::delete('/{id?}', 'destroy')->name('delete');
            Route::get('/getData', 'getData')->name('getData');
        });
        Route::controller(TransmissionController::class)->prefix('transmission')->name('transmission.')->group(function () {
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
        Route::controller(DealsController::class)->prefix('deals')->name('deals.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
            Route::post('/update', 'update')->name('update');
            Route::delete('/{uuid}', 'destroy')->name('delete');
            Route::get('/getData', 'getData')->name('getData');
        });
        Route::controller(TypeController::class)->prefix('usertype/type')->name('usertype.type.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
            Route::post('/update', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('delete');
            Route::get('/getData', 'getData')->name('getData');
        });

        Route::controller(UserTypeController::class)->prefix('usertype')->name('usertype.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
            Route::post('/update', 'update')->name('update');
            Route::delete('/{uuid}', 'destroy')->name('delete');
            Route::get('/getData', 'getData')->name('getData');
            Route::get('/area/{id}', 'area')->name('area');
            Route::get('/country/{id}', 'country')->name('country');
        });
        Route::controller(AdsCarController::class)->prefix('ads/car')->name('ads.car.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
            Route::post('/update', 'update')->name('update');
            Route::delete('/{uuid}', 'destroy')->name('delete');
            Route::get('/getData', 'getData')->name('getData');
            Route::get('/images/{id}', 'showImages')->name('showImages');
            Route::delete('/images/{id}/{idd}', 'deleteimages')->name('deletemages');
            Route::post('update/images', 'updateImages')->name('updateImages');

            Route::get('/show/card/', 'showCard')->name('showCard');
            Route::get('model/{id}', [DataController::class,'model'])->name('model');

        });
        Route::controller(SettingController::class)->prefix('setting')->name('setting.')->group(function (){
            Route::get('/year', 'getyear')->name('getyear');
            Route::post('/year', 'year')->name('year');
            Route::post('/video', 'video')->name('video');
        });

        Route::controller(UserOrderController::class)->prefix('orders')->name('orders.')->group(function () {
            Route::get('/', 'index')->name('index')->middleware('read');
            Route::get('/getData', 'getData')->name('getData');
            Route::delete('/{uuid}', 'destroy')->name('delete');
            Route::post('/accepted/{uuid}', 'accepted')->name('accepted');
            Route::post('/rejected/{uuid}', 'rejected')->name('rejected');
            Route::delete('{uuid}','destroy')->name('delete');

        });


    }
);


