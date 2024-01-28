<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\DefermentApplication;
use App\Policies\DefermentApplicationPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Str;

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

        Str::macro('colorStatus',function ($status){
            switch (strtolower($status)){
                case 'reviewing':
                    return '<h3 class="capitalize text-violet-800 text-lg font-semibold">'.$status.'</h3>';
                case 'process':
                    return '<h3 class="capitalize text-lg text-blue-700 font-semibold">'.$status.'</h3>';
                case 'rejected':
                    return '<h3 class="capitalize text-red-700 text-lg font-semibold">'.$status.'</h3>';
                case 'pending':
                    return '<h3 class="capitalize text-lg text-yellow-500 font-semibold">'.$status.'</h3>';
                case 'approved':
                    return '<h3 class="capitalize text-green-700 text-lg font-semibold ">'.$status.'</h3>';
                case 'draft':
                    return '<h3 class="capitalize text-lg text-gray-500 font-semibold">'.$status.'</h3>';
            }

        });
    }
}
