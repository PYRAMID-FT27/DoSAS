<?php

namespace App\Providers;

use App\Contract\Repository\DefermentApplicationRepositoryInterface;
use App\Models\DefermentApplication;
use App\Services\DefermentApplicationService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $contracts = [
            DefermentApplicationRepositoryInterface::class => DefermentApplication::class,


            // services
            \App\Contract\Services\DefermentApplication::class=> DefermentApplicationService::class
        ];

        foreach ($contracts as $contract => $class) {
            $this->app->bind($contract, $class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
