<?php

namespace App\Services;

use App\Contract\Repository\DefermentApplicationRepositoryInterface;
use App\Contract\Services\DefermentApplication;
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
                                                    ->paginate(10);
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
       if ($defApp->submitted_at) throw new \Exception('this application can not update it');
        $defApp->update([
           'student_id',
           'status'=> self::ACTION_TYPE[$inputs['action']],
           'submitted_at' =>$inputs['action']=='submit'?now():null,
           'semester'=>$inputs['semester'],
           'type'=>$inputs['type'],
           'details'=>$inputs['details'],
           'notes'=>$inputs['action']=='submit'?"your application is to be reviewed by your supervisors":'-',
       ]);
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
}
