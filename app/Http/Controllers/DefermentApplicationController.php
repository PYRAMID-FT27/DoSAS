<?php

namespace App\Http\Controllers;

use App\Contract\Services\DefermentApplication;
use App\Http\Requests\StoreDefermentApplicationRequest;
use App\Http\Requests\UpdateDefermentApplicationRequest;

class DefermentApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DefermentApplication $defermentApplicationService)
    {
        $defermentApplications = $defermentApplicationService->setParameters(['user'=>auth()->user()])
                                                        ->process()
                                                        ->listApplication()
                                                        ->output('applications');
        return view('application.index',compact('defermentApplications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDefermentApplicationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DefermentApplication $defermentApplication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DefermentApplication $defermentApplication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDefermentApplicationRequest $request, DefermentApplication $defermentApplication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DefermentApplication $defermentApplication)
    {
        //
    }
}
