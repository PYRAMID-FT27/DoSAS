<?php

namespace App\Observers;

use App\Contract\Services\TrackingLogger;
use App\Models\DefermentApplication;
use Illuminate\Support\Facades\App;

class DefermentApplicationObserver
{
    private TrackingLogger $tracking;

    public function __construct()
    {

        $this->tracking = app(TrackingLogger::class);
    }
    /**
     * Handle the DefermentApplication "created" event.
     */
    public function created(DefermentApplication $defermentApplication): void
    {
        if (!App::runningInConsole()) {
            $this->tracking->setParameters(['da' => $defermentApplication])->process();
        }
    }

    /**
     * Handle the DefermentApplication "updated" event.
     */
    public function updated(DefermentApplication $defermentApplication): void
    {
        if (!App::runningInConsole()) {
            $previousState = $defermentApplication->getOriginal('status');
            $newState = $defermentApplication->getAttribute('status');
            $this->tracking->setParameters([
                'da' => $defermentApplication,
                'previousState' =>$previousState,
                'newState' =>$newState,
            ])->process();
        }

    }

    /**
     * Handle the DefermentApplication "deleted" event.
     */
    public function deleted(DefermentApplication $defermentApplication): void
    {
        //
    }

    /**
     * Handle the DefermentApplication "restored" event.
     */
    public function restored(DefermentApplication $defermentApplication): void
    {
        //
    }

    /**
     * Handle the DefermentApplication "force deleted" event.
     */
    public function forceDeleted(DefermentApplication $defermentApplication): void
    {
        //
    }
}
