<?php

namespace App\Models;

use App\Contract\Repository\DefermentApplicationRepositoryInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    ];
    public static $errorMessages= [
        'docs.*' => 'Only files with the following formats are accepted: JPEG, JPG, PDF, DOC, and DOCX!',
        'docs.required_if' => 'you should write deferment details before submit your application!'
    ];

    public function applicationLog(): HasMany
    {
        return $this->hasMany(ApplicationLog::class);
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
        switch ($this->status){
            case 'reviewing':
               return '<span class="bg-blue-100 text-blue-800 text-sm font-bold me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">'.$this->status.'</span>';
            case 'draft':
               return '<span class="bg-gray-100 text-gray-800 text-sm font-bold me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">'.$this->status.'</span>';

        }
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
        return empty($this->submitted_at);
    }
}
