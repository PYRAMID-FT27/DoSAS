<?php

namespace App\Models;

use App\Contract\Repository\DALoggerRepositoryInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationLog extends Model implements DALoggerRepositoryInterface
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
