<?php

namespace App\Http\Controllers;

use App\Contract\Services\DefermentApplication as DefermentApplicationService;
use App\Http\Requests\StoreDefermentApplicationRequest;
use App\Http\Requests\UpdateDefermentApplicationRequest;
use App\Models\DefermentApplication;

class DefermentApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DefermentApplicationService $defermentApplicationService)
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
        $student = auth()->user()->student;
        $types = config('dosas.type');
        $status = config('dosas.status');
        $semesters = config('dosas.semester');

        return view('application.create',compact('types','student','status','semesters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDefermentApplicationRequest $request,DefermentApplicationService $defermentApplicationService)
    {
        try {
            $request->validated();
            $defermentApplicationService->setParameters(['inputs'=>$request->all(),'user'=>auth()->user()])->createApplication();
            return redirect()->route('defermentApplication.index');
        }catch (\Throwable $throwable){
            dd($throwable);
            notify()->error($throwable->getMessage());
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(DefermentApplication $defermentApplication,DefermentApplicationService $defermentApplicationService)
    {
        try {
            $defermentApplicationService->setParameters([
                'da'=>$defermentApplication,
                'user'=>auth()->user()
            ])->showDdefermentApplication();
            $actions = DefermentApplication::ACTIONS;
            $applicationLogs = $defermentApplicationService->output('applicationLogs');
            $student = $defermentApplicationService->output('student');
            $documents = $defermentApplicationService->output('documents');
            return view('application.show',compact('applicationLogs','actions','documents','student','defermentApplication'));
        }catch (\Throwable $throwable){
            dd($throwable);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DefermentApplication $defermentApplication)
    {
        $types = config('dosas.type');
        $status = config('dosas.status');
        $semesters = config('dosas.semester');
        $student = $defermentApplication->student;

        $doucments = $defermentApplication->load('documents')->documents()->get();
        return view('application.edit',compact('defermentApplication','types','status','student','doucments','semesters'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDefermentApplicationRequest $request, DefermentApplication $defermentApplication, DefermentApplicationService $defermentApplicationService)
    {
        try {
            $request->validated();
            $defermentApplicationService->setParameters(['inputs'=>$request->all(),'da'=>$defermentApplication,'user'=>auth()->user()])->updateApplications();
            return redirect()->route('defermentApplication.index');
        }catch (\Throwable $throwable){
            dd($throwable);
           notify()->error($throwable->getMessage());
            return redirect()->route('defermentApplication.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DefermentApplication $defermentApplication)
    {
       $this->authorize('delete',$defermentApplication);
       $defermentApplication->delete();
       notify()->warning('Application has been deleted successfully');
       return redirect()->back();
    }
}
