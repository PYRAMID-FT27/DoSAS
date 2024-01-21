<?php

namespace App\Services;

use App\Contract\Repository\DefermentApplicationRepositoryInterface;
use App\Contract\Services\DefermentApplication;

class DefermentApplicationService extends BaseService implements DefermentApplication
{
    protected $required = ['user'];
    protected $numberPerPage = 10;
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
}
