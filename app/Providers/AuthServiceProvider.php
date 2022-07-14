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
        'App\Model' => 'App\Policies\ModelPolicy',
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

        Passport::tokensCan([
            'view-all-posts'=> 'View all posts',
            'single-post'=> 'View single post',
        ]);

        Gate::define('isAdmin', function(){
            $roles = session()->get('roles') ? session()->get('roles') : [];
            return in_array('admin',$roles);
        });

        Gate::define('isGuru', function(){
            $roles = session()->get('roles') ? session()->get('roles') : [];
            return in_array('guru',$roles);
        });

        Gate::define('isBpsh', function(){
            $roles = session()->get('roles') ? session()->get('roles') : [];
            return in_array('bpsh',$roles);
        });

    }
}
