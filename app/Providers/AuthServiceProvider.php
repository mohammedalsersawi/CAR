<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            if ($user->email=="admin@admin") {
                return true;
            }
        });

        if (auth('web')){
            foreach (config('ability') as $code => $lable) {
                Gate::define($code, function($user) use ($code) {
                    return $user->hasAbility($code);
                });
            }
        }
        Gate::define('SHOWROOM',function (){
            return (auth('user')->user()->user_type_id==User::SHOWROOM)? true:false;
        });
        Gate::define('DISCOUNT_STORE',function (){
            return (auth('user')->user()->user_type_id==User::DISCOUNT_STORE)? true:false;
        });
        Gate::define('PHOTOGRAPHER',function (){
            return (auth('user')->user()->user_type_id==User::PHOTOGRAPHER)? true:false;
        });

    }
}
