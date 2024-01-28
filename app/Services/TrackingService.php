<?php

namespace App\Services;

use App\Contract\Repository\DALoggerRepositoryInterface;
use App\Contract\Services\TrackingLogger;


class TrackingService extends BaseService implements TrackingLogger
{
    private const  ACTIONS = [
        'rejected' => 'Rejection',
        'approved' => 'Approval',
        'reviewing' => 'Reviewing',
        'process' => 'Processing',
        'draft' => 'create',
        'pending' => 'Pending'
    ];

    private DALoggerRepositoryInterface $loggerRepository;

    public function __construct(DALoggerRepositoryInterface $loggerRepository)
    {

        $this->loggerRepository = $loggerRepository;
    }


    public function process()
    {
        $da = $this->parameterBag['da'];
        $previousState = $this->parameterBag['previousState']??'-';
        $newState = $this->parameterBag['newState']??$da->status;
        $da = $this->parameterBag['da'];
        if (empty($da)) throw new \Exception('application missing');
        $this->loggerRepository->create([
            'application_id'=>$da->id,
            'changed_by'=>auth()->id(),
            'changed_at'=>now(),
            'previous_status'=>$previousState,
            'new_status'=>$newState,
            'remarks'=>$da->notes,
            'action_type'=>self::ACTIONS[$newState],
        ]);
    }
}
