<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();
        Gate::define('isAdmin',function ($user){
            return $user-> role == 'admin';
        });
        Gate::define('isWriter',function ($user){
            return $user-> role == 'writer';
        });
        Gate::define('isEditor',function ($user){
            return $user-> role == 'editor';
        });
        Gate::define('isAdminOrisEditor',function ($user){
            return $user-> role == 'admin' || $user-> role == 'editor';
        });
    }
}
