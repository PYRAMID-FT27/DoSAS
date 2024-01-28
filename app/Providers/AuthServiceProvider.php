<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\DefermentApplication;
use App\Policies\DefermentApplicationPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        DefermentApplication::class => DefermentApplicationPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Auth::macro('isLoginBy',function (){
            $guards = array_keys(config('auth.guards'));
            foreach ($guards as $guard) {
                if (Auth::guard($guard)->check()) {
                    return $guard;
                }
            }
        });
    }
}
