<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {

        Gate::define("create_update_delete_announcements",function(User $user){
            if($user->role === "Admim"){
                return true;
            }
        });

        Gate::define("create_update_delete_books",function(User $user){
            if($user->role === "Admim" || $user->role === "Teacher"){
                return true;
            }
        });

        Gate::define("create_delete_users", function(User $user){
            if($user->role === "Admin"){
                return true;
            }
        });


    }
}
