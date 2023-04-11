<?php

use App\Http\Controllers\Admin\Ads\AdsCarController;
use App\Http\Controllers\Admin\Car\Brand\BrandController;
use App\Http\Controllers\Admin\Car\Color\ColorController;
use App\Http\Controllers\Admin\Car\Engine\EngineController;
use App\Http\Controllers\Admin\Car\FulType\FuelTypeController;
use App\Http\Controllers\Admin\Car\Model\ModelController;
use App\Http\Controllers\Admin\Car\Transmission\TransmissionController;
use App\Http\Controllers\Admin\DataController;
use App\Http\Controllers\Admin\Deals\DealsController;
use App\Http\Controllers\Admin\order\UserOrderController;
use App\Http\Controllers\Admin\Photographer\PhotographerController;
use App\Http\Controllers\Admin\places\area\AreaControllerr;
use App\Http\Controllers\Admin\places\City\CityController;
use App\Http\Controllers\Admin\places\country\CountryController;
use App\Http\Controllers\Admin\Plates\PlatesController;
use App\Http\Controllers\Admin\Role\RolesController;
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

        Route::middleware('auth:web')->group(function () {
//            Route::view('/index', 'admin.part.app');
            Route::get('/admin/profile',[\App\Http\Controllers\Admin\Profile\ProfileController::class,'index'])->name('profile');

        Route::controller(ModelController::class)->name('model.')->prefix('model')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
            Route::post('/update', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('delete');
            Route::get('/getData', 'getData')->name('getData');
            Route::put('/activate/{uuid}', 'activate')->name('activate');
        });
        Route::controller(EngineController::class)->prefix('engines')->name('engines.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
            Route::post('/update', 'update')->name('update');
            Route::delete('/{uuid}', 'destroy')->name('delete');
            Route::get('/getData', 'getData')->name('getData');
            Route::put('/activate/{uuid}', 'activate')->name('activate');
        });
        Route::controller(FuelTypeController::class)->prefix('fuel/type')->name('fuelType.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
            Route::post('//update', 'update')->name('update');
            Route::delete('/{uuid}', 'destroy')->name('delete');
            Route::GET('/getData', 'getData')->name('getData');
            Route::put('/activate/{uuid}', 'activate')->name('activate');
        });
        Route::controller(BrandController::class)->prefix('brand')->name('brand.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
            Route::post('/update', 'update')->name('update');
            Route::delete('/{uuid}', 'destroy')->name('delete');
            Route::get('/getData', 'getData')->name('getData');
            Route::put('/activate/{uuid}', 'activate')->name('activate');
        });
        Route::controller(ColorController::class)->prefix('color')->name('color.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
            Route::post('/update', 'update')->name('update');
            Route::delete('/{uuid}', 'destroy')->name('delete');
            Route::get('/getData', 'getData')->name('getData');
            Route::put('/activate/{uuid}', 'activate')->name('activate');
        });
        Route::controller(TransmissionController::class)->prefix('transmission')->name('transmission.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
            Route::post('/update', 'update')->name('update');
            Route::delete('/{uuid}', 'destroy')->name('delete');
            Route::get('/getData', 'getData')->name('getData');
            Route::put('/activate/{uuid}', 'activate')->name('activate');
        });
        Route::controller(CityController::class)->prefix('city')->name('city.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
            Route::post('/update', 'update')->name('update');
            Route::delete('/{uuid}', 'destroy')->name('delete');
            Route::get('/getData', 'getData')->name('getData');
            Route::put('/activate/{uuid}', 'activate')->name('activate');
        });
        Route::controller(CountryController::class)->prefix('country')->name('country.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
            Route::post('/update', 'update')->name('update');
            Route::delete('/{uuid}', 'destroy')->name('delete');
            Route::get('/getData', 'getData')->name('getData');
            Route::put('/activate/{uuid}', 'activate')->name('activate');
        });
        Route::controller(AreaControllerr::class)->prefix('area')->name('area.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
            Route::post('/update', 'update')->name('update');
            Route::delete('/{uuid}', 'destroy')->name('delete');
            Route::get('/getData', 'getData')->name('getData');
            Route::put('/activate/{uuid}', 'activate')->name('activate');
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
            Route::delete('/{uuid}', 'destroy')->name('delete');
            Route::get('/getData', 'getData')->name('getData');
        });

        Route::controller(UserTypeController::class)->prefix('users')->name('usertype.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
            Route::post('/update', 'update')->name('update');
            Route::delete('/{uuid}', 'destroy')->name('delete');
            Route::get('/getData', 'getData')->name('getData');
            Route::get('/area/{uuid}', 'area')->name('area');
            Route::get('/country/{uuid}', 'country')->name('country');
        });
        Route::controller(AdsCarController::class)->prefix('ads/car')->name('ads.car.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
            Route::post('/update', 'update')->name('update');
            Route::delete('/{uuid}', 'destroy')->name('delete');
            Route::get('/getData', 'getData')->name('getData');
            Route::delete('/images/{uuid}/{id}', 'deleteimages')->name('deletemages');
            Route::get('/images/{uuid}', 'showImages')->name('showImages');

            Route::post('update/images', 'updateImages')->name('updateImages');
            Route::get('/show/card/', 'showCard')->name('showCard');
            Route::get('model/{uuid}', [DataController::class,'model'])->name('model');

        });
        Route::controller(SettingController::class)->prefix('setting')->name('setting.')->group(function (){
            Route::get('/year', 'getyear')->name('getyear');
            Route::post('/year', 'year')->name('year');
            Route::post('/video', 'video')->name('video');
        });
        Route::controller(UserOrderController::class)->prefix('orders')->name('orders.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/getData', 'getData')->name('getData');
            Route::delete('/{uuid?}', 'destroy')->name('delete');
            Route::post('/accepted/{uuid}', 'accepted')->name('accepted');
            Route::post('/rejected/{uuid}', 'rejected')->name('rejected');
            Route::delete('{uuid}','destroy')->name('delete');
        });
        Route::controller(\App\Http\Controllers\Admin\OrderAppointment\OrderController::class)->name('OrderAppointment.')->prefix('Appointment')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
            Route::post('/update', 'update')->name('update');
            Route::delete('/{uuid}', 'destroy')->name('delete');
            Route::get('/getData', 'getData')->name('getData');
            Route::post('/accept', 'accept')->name('accept');
            Route::get('/user/Photographer/{city}/{area}', 'getuser')->name('users');
        });
        Route::controller(PlatesController::class)->name('Plates.')->prefix('Plates')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
            Route::post('/update', 'update')->name('update');
            Route::delete('/{uuid}', 'destroy')->name('delete');
            Route::get('/getData', 'getData')->name('getData');
        });
        Route::controller(\App\Http\Controllers\Admin\Admins\AdminController::class)->name('admin.')->prefix('admins')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/store', 'store')->name('store');
                Route::post('/update', 'update')->name('update');
                Route::delete('/{uuid}', 'destroy')->name('delete');
                Route::get('/getData', 'getData')->name('getData');
                Route::put('/activate/{uuid}', 'activate')->name('activate');
                Route::get('/edit/{uuid}', 'edit')->name('edit');
        });
            Route::resource('role',RolesController::class);
        });
        Route::middleware('auth:user')->prefix('user')->name('user.')->group(function (){
            Route::get('/profile',[\App\Http\Controllers\User\Profile\ProfileController::class,'index'])->name('profile');

            Route::get('/appointment',[\App\Http\Controllers\User\photograoher\OrderAppointmentController::class,'index'])->name('appointment');
            Route::get('/appointment/getData', [\App\Http\Controllers\User\photograoher\OrderAppointmentController::class,'getData'])->name('appointment.getData');
            Route::post('/appointment/accept', [\App\Http\Controllers\User\photograoher\OrderAppointmentController::class,'accept'])->name('accept');
            Route::post('/appointment/store/ads', [\App\Http\Controllers\User\photograoher\OrderAppointmentController::class,'store'])->name('appointment.ads');

            Route::get('/deals',[\App\Http\Controllers\User\deal\UserDealController::class,'index'])->name('deal');
            Route::get('/deals/getData', [\App\Http\Controllers\User\deal\UserDealController::class,'getData'])->name('deal.getData');
            Route::post('/deal/store',[\App\Http\Controllers\User\deal\UserDealController::class,'store'])->name('deal.store');
            Route::post('/deal/update', [\App\Http\Controllers\User\deal\UserDealController::class,'update'])->name('deal.update');
            Route::delete('/deals/{uuid}', [\App\Http\Controllers\User\deal\UserDealController::class,'destroy'])->name('deals.delete');

            Route::get('/ads',[\App\Http\Controllers\User\ads\UserAdsController::class,'index'])->name('ads');
            Route::get('/ads/getData', [\App\Http\Controllers\User\ads\UserAdsController::class,'getData'])->name('ads.getData');
            Route::post('/ads/store',[\App\Http\Controllers\User\ads\UserAdsController::class,'store'])->name('ads.store');
            Route::post('/ads/update', [\App\Http\Controllers\User\ads\UserAdsController::class,'update'])->name('ads.update');
            Route::delete('/ads/{uuid}', [\App\Http\Controllers\User\ads\UserAdsController::class,'destroy'])->name('ads.delete');
            Route::delete('/ads/images/{uuid}/{id}',[\App\Http\Controllers\User\ads\UserAdsController::class,'deleteimages'] )->name('ads.deletemages');
            Route::get('/ads/images/{uuid}',[\App\Http\Controllers\User\ads\UserAdsController::class,'showImages'] )->name('ads.showImages');
            Route::post('/ads/update/images',[\App\Http\Controllers\User\ads\UserAdsController::class,'updateImages'] )->name('ads.updateImages');
            Route::get('/ads/show/card/',[\App\Http\Controllers\User\ads\UserAdsController::class,'showCard'] )->name('ads.showCard');
            Route::get('/model/{uuid}', [DataController::class,'model'])->name('model');

        });
    }


);


