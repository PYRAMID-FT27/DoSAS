<?php

namespace App\Services;

use App\Contract\Repository\DefermentApplicationRepositoryInterface;
use App\Contract\Services\DefermentApplication;
use App\Mail\SubmittedApplication;
use App\Models\ApplicationLog;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class DefermentApplicationService extends BaseService implements DefermentApplication
{
    protected $required = ['user'];
    protected $numberPerPage = 10;
    protected const ACTION_TYPE =[
        'save' =>'draft',
        'submit' =>'reviewing',
        ];
    private DefermentApplicationRepositoryInterface $applicationRepository;

    public function __construct(DefermentApplicationRepositoryInterface $applicationRepository)
    {

        $this->applicationRepository = $applicationRepository;
    }
    public function process()
    {
        $this->validate();
        return $this;
    }
    public function listApplication()
    {
        $user = $this->parameterBag['user'];
       $role = $user->role;
       switch ($role){
           case 'student':
               $this->output['applications'] = $user->student
                                                    ->applications()
                                                    ->latest()
                                                    ->paginate(10);
               break;
           case 'faculty':
               $this->output['applications'] = $this->fetchSupervisorStudentApplications();
               break;
           case 'staff':
               $this->output['applications'] = $this->fetchStudentApplications();
               break;
           default:
               throw new \Exception('Invalid type');
       }
       return $this;
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function validate(): void
    {
        foreach ($this->required as $parameter) {
            if (empty($this->parameterBag[$parameter])) throw new \Exception(sprintf('%s parameter is required', $parameter));
        }
    }

    public function updateApplications()
    {
       $defApp =  $this->parameterBag['da'];
       $inputs =  $this->parameterBag['inputs'];
       $user =  $this->parameterBag['user'];
       if ((!$defApp->isEditable()) && $user->isStudent()) throw new \Exception('this application can not update it');
       switch ($user->role){
           case 'student':
               $defApp->update([
                   'status'=> self::ACTION_TYPE[$inputs['action']],
                   'submitted_at' =>$inputs['action']=='submit'?now():null,
                   'semester'=>$inputs['semester'],
                   'type'=>$inputs['type'],
                   'details'=>$inputs['details'],
                   'notes'=>$inputs['action']=='submit'?"application is to be reviewed by supervisor":'draft application',
               ]);
               $inputs['action']=='submit'? notify()->success('your application has been submitted successfully') :notify()->info('your application has been saved successfully');
               if (isset($inputs['docs'])) $this->saveDocuments($inputs['docs'], $user, $defApp);
               break;
           case 'faculty':
           case 'staff':
               $defApp->update([
                   'status'=> $inputs['action'],
                   'notes'=>$inputs['remarks']
               ]);
               notify()->success('an application has been updated successfully');
               break;
       }

    }
    public function createApplication()
    {
        $inputs =  $this->parameterBag['inputs'];
        $user =  $this->parameterBag['user'];
        $count = (new \App\Models\DefermentApplication())->applicationApprovedCredit($user->student->id);

        if ($inputs['action']=='submit' && $count == config('dosas.max-credit')){
            throw new \Exception('You have reached your limit of two approved deferment applications.');
        }
        $defApp = $user->student->applications()->create([
            'status'=> self::ACTION_TYPE[$inputs['action']],
            'submitted_at' =>$inputs['action']=='submit'?now():null,
            'semester'=>$inputs['semester'],
            'type'=>$inputs['type'],
            'details'=>$inputs['details'],
            'notes'=>$inputs['action']=='submit'?"your application is to be reviewed by your supervisors":'draft application',
        ]);
        if ($inputs['action']=='submit'){
            $ms = $user->student->mainSupervisor();
            Mail::to($user->email)->bcc($ms->user->email)->send(new SubmittedApplication($defApp));
            notify()->success('your application has been submitted successfully');
        }else{
            notify()->info('your application has been saved successfully');
        }
        if (isset($inputs['docs'])) $this->saveDocuments($inputs['docs'], $user, $defApp);

    }

    /**
     * @param mixed $user
     * @return string
     */
    protected function getFolderName(string $studentName): string
    {
        return sprintf('documents/%s/', str_replace(' ', '-', strtolower($studentName)));
    }

    /**
     * @param mixed $doc
     * @return string
     */
    protected function generateFileName(string $extension): string
    {
        return md5(now()).'.'. $extension;
    }

    /**
     * @param $docs
     * @param mixed $user
     * @param mixed $defApp
     * @return void
     */
    public function saveDocuments($docs, mixed $user, mixed $defApp): void
    {
        foreach ($docs as $doc) {
            $path = $doc->storeAs($this->getFolderName($user->name), $this->generateFileName($doc->extension()), 'public');
            $defApp->documents()->create([
                'type' => $doc->getMimeType(),
                'path' => $path,
                'file_name' => $doc->getClientOriginalName(),
                'description' => sprintf('this supporting document for %s - %s', $defApp->type, $defApp->semester),
            ]);
        }
    }

    private function fetchSupervisorStudentApplications()
    {
        $supervisorId = $this->parameterBag['user']->meta()->id;
        $supervisorUserId = $this->parameterBag['user']->id;

        return \App\Models\DefermentApplication::where(function ($query) use ($supervisorId,$supervisorUserId){
            $query->whereHas('student.supervisors', function ($query) use ($supervisorId) {
                $query->where('supervisor_id', $supervisorId)
                      ->where('supervisor_type', 'main');
            });
            $query->orWhereHas('student.supervisors', function ($subQuery) use ($supervisorUserId) {
                $subQuery->where('user_id', $supervisorUserId)
                         ->where('supervisor_type', 'coordinator');

            })
                ->whereHas('applicationLog', function ($subQuery) use ($supervisorUserId) {
                $subQuery->whereHas('user',function ($userQuery){
                        $userQuery->where('role','faculty');
                    })
                    ->where('action_type', 'Approval');
            });

        })->where('status', '!=', 'draft')
            ->latest()
            ->paginate(10);
    }
    private function fetchStudentApplications()
    {
        return \App\Models\DefermentApplication::whereHas('applicationLog', function ($subQuery) {
            $subQuery->where('action_type', 'Approval');
        })->latest()->paginate(10);

    }
    public function showDdefermentApplication()
    {
        $defermentApplication = $this->parameterBag['da'];
        $user = $this->parameterBag['user'];
        $defermentApplication->load('applicationLog');
        $defermentApplication->load('documents');
        $documents = $defermentApplication->documents()->get();
        $student =  $defermentApplication->student;
        switch ($user->role){
            case 'student':
                $applicationLogs = $defermentApplication->applicationLog()
                    ->orderByDesc('created_at')
                    ->get()->groupBy(function ($log){
                        return $log->created_at->format('F j, Y [ H:i ]');
                    });
                break;
            case 'faculty':
            case 'staff':
                $applicationLogs = $defermentApplication->applicationLog()
                    ->orderByDesc('created_at')
                    ->get()->groupBy(function ($log){
                        return $log->created_at->format('F j, Y [ H:i ]');
                    });
                break;
        }
        $this->output['applicationLogs'] = $applicationLogs;
        $this->output['student'] = $student;
        $this->output['documents'] = $documents;
        $this->output['prevApplications'] = $this->applicationRepository->where('student_id',$defermentApplication->student_id)
                                                                        ->where('status','!=','draft')
                                                                        ->where('id','!=',$defermentApplication->id)
                                                                        ->get();
    }
}
