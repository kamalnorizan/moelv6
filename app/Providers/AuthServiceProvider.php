<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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

        Gate::define('isAdmin', function(){
            return in_array('admin',session()->get('roles'));

        });

        Gate::define('isGuru', function(){
            return in_array('guru',session()->get('roles'));


        });

        Gate::define('isBpsh', function(){
            return in_array('bpsh',session()->get('roles'));
        });
    }
}
