<?php

namespace App\Http\Controllers;

use App\Contract\Services\DefermentApplication as DefermentApplicationService;
use App\Http\Requests\StoreDefermentApplicationRequest;
use App\Http\Requests\UpdateDefermentApplicationRequest;
use App\Models\DefermentApplication;
use App\Models\Document;
use App\Rules\UserHasDocument;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\ValidatedInput;
use Illuminate\Validation\Rule;

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
        return view('application.create');
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
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DefermentApplication $defermentApplication)
    {
        //
    }
}
