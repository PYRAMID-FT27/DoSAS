<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationLog extends Model
{
    use HasFactory;
    protected $fillable=[
        'application_id',
        'changed_by',
        'changed_at',
        'previous_status',
        'new_status',
        'remarks',
        'action_type',
    ];

    public function DefermentApplication()
    {
      return $this->belongsTo(DefermentApplication::class);
    }
}
