<?php

namespace App\Models;

use App\Contract\Repository\DefermentApplicationRepositoryInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class DefermentApplication extends Model implements DefermentApplicationRepositoryInterface
{
    use HasFactory;
    protected $fillable =[
        'student_id',
        'status',
        'submitted_at',
        'semester',
        'type',
        'details',
        'notes',
    ];
    public static $roles = [
        'docs.*' => 'mimes:jpeg,jpg,pdf,doc,docx|max:10000',
        'details' => 'required_if:action,submit',
        'semester' => 'required_if:action,submit',
        'type' => 'required_if:action,submit',
    ];
    public const ACTIONS = [
        'rejected' => 'Rejection',
        'approved' => 'Approval',
        'reviewing' => 'Reviewing',
        'process' => 'Processing',
        'pending' => 'Pending'
    ];
    public static $color = [
        'rejected' => 'red-700',
        'approved' => 'green-700',
        'reviewing' => 'gray-700',
        'process' => 'blue-700',
        'pending' => 'yellow-500'
    ];
    public static $errorMessages= [
        'docs.*' => 'Only files with the following formats are accepted: JPEG, JPG, PDF, DOC, and DOCX!',
        'docs.required_if' => 'you should write deferment details before submit your application!',
        'semester.required_if' => 'you need to select semester!',
        'type.required_if' => 'kindly select deferment reason type!',
        'details' => 'kindly provide Proposal of your deferment request!',
    ];

    public function applicationLog(): HasMany
    {
        return $this->hasMany(ApplicationLog::class,'application_id','id');
    }

    public function isApprovedByCurrentUser()
    {
        return $this->applicationLog()
                    ->where('changed_by', auth()->id())
                    ->where('action_type', 'Approval')
                    ->where('application_id', $this->id)
                    ->exists();
    }
    public function latestChange()
    {
        return $this->applicationLog()->latest()->first();
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class,'application_id','id');
    }
    public function getStatus()
    {
        switch (strtolower($this->status)){
            case 'reviewing':
               return '<span class="text-blue-800 text-base font-bold me-2 px-2.5 py-0.5 rounded capitalize">'.$this->status .' '.$this->statusByUser().'</span>';
            case 'process':
               return '<span class="text-blue-800 text-base font-bold me-2 px-2.5 py-0.5 rounded capitalize">'.$this->status .' '.$this->statusByUser().'</span>';
            case 'rejected':
               return '<span class="text-red-800 text-base font-bold me-2 px-2.5 py-0.5 rounded capitalize">'.$this->status .' '.$this->statusByUser().'</span>';
            case 'pending':
               return '<span class="bg-blue-100 text-yellow-500 text-base font-bold me-2 px-2.5 py-0.5 rounded capitalize">'.$this->status .' '.$this->statusByUser().'</span>';
            case 'approved':
               return '<span class="text-green-700 text-base font-bold me-2 px-2.5 py-0.5 rounded capitalize">'.$this->status .' '.$this->statusByUser().'</span>';
            case 'draft':
               return '<span class="bg-gray-100 text-gray-800 text-base font-bold me-2 px-2.5 py-0.5 rounded">'.$this->status .' '.$this->statusByUser().'</span>';

        }
    }
    public function statusByUser()
    {
       $by =  $this->latestChange()->changeByUser();
       return empty($by)?'':'By '.$by;
    }

    public function getType()
    {
        switch ($this->type){
            case 'medical':
               return '<span class="bg-red-100 text-red-800 text-sm font-bold me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-300 border border-red-300">'.$this->type.'</span>';
            case 'academic':
                return '<span class="bg-yellow-100 text-yellow-800 text-sm font-bold me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300">'.$this->type.'</span>';
            case 'personal':
               return '<span class="bg-blue-100 text-blue-800 text-sm font-bold me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-300 border border-blue-300">'.$this->type.'</span>';
            case 'other':
               return '<span class="bg-orange-100 text-orange-800 text-sm font-bold me-2 px-2.5 py-0.5 rounded dark:bg-blue-700 dark:text-orange-300">'.$this->type.'</span>';

        }
    }

    public function isEditable(): bool
    {
        return empty($this->submitted_at) || ($this->submitted_at && $this->status =='pending');
    }

    public function applicationApprovedCredit($id)
    {
        return $this->where('student_id', $id)
        ->where('id', '!=', $this->id)
        ->where('status', 'approved')
        ->whereHas('applicationLog', function ($query) {
            $query->whereHas('user', function ($query) {
                $query->where('role', 'staff');
            });
        })->whereIn('type', ['academic', 'personal' ,'medical'])
          ->count();
    }
}
