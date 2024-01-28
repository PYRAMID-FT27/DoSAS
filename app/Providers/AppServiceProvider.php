<?php

namespace App\Providers;

use App\Contract\Repository\DALoggerRepositoryInterface;
use App\Contract\Repository\DefermentApplicationRepositoryInterface;
use App\Contract\Services\TrackingLogger;
use App\Models\ApplicationLog;
use App\Models\DefermentApplication;
use App\Observers\DefermentApplicationObserver;
use App\Services\DefermentApplicationService;
use App\Services\TrackingService;
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
            DALoggerRepositoryInterface::class=>ApplicationLog::class,

            // services
            \App\Contract\Services\DefermentApplication::class=> DefermentApplicationService::class,
            TrackingLogger::class => TrackingService::class
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
        DefermentApplication::observe(DefermentApplicationObserver::class);
    }
}
