<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $request=request();
        if($request->is('user/*')){
            Config::set('fortify.guard','user');
            Config::set('fortify.passwords','users');
            Config::set('fortify.prefix','user');
            Config::set('fortify.username','phone');
            Config::set('fortify.email','phone');
            //  Config::set('fortify.home',RouteServiceProvider::ADMIN);

        }
        $this->app->instance(LoginResponse::class, new class implements LoginResponse {
            public function toResponse($request)
            {
                if($request->is('user/*')){
                    return redirect()->intended('user/profile');
                }
                return redirect()->intended('admin/profile');
            }
        });
        $this->app->instance(LogoutResponse::class, new class implements LogoutResponse {
            public function toResponse($request)
            {
                if(!$request->is('user/*')){
                    return redirect()->intended('/user/login');

                }
                    return redirect()->intended('/login');





            }
        });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(5)->by($email.$request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });


        if (Config::get('fortify.guard')=='web') {
            Fortify::loginView(function () {
                return view('admin.auth.login');
            });
            Fortify::authenticateUsing(function ($req){
                $admin=Admin::where('email',$req->email)->first();
                if ($admin){
                    return   ($admin->status==1)?$admin: abort(403);
                }else{
                    return false;
                }
            });
            Fortify::requestPasswordResetLinkView('admin.auth.forgot-password');
            Fortify::resetPasswordView(function($request) {
                return view('admin.auth.reset-password', ['request' => $request]);
            });
        }else{
            Fortify::authenticateUsing(function ($req){
                $user=User::where('phone',$req->phone)->whereNot('user_type_id',User::USER)->first();
                if ($user){
                    return   (!$user->status==1)?$user: abort(403);
                }else{
                    return false;
                }
            });
            Fortify::loginView(function () {
                return view('user.auth.login');
            });

        }
    }
}
