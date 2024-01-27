<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'file_name',
        'type',
        'path',
        'description',
    ];

    public function defermentApplication()
    {
      $this->belongsTo(DefermentApplication::class);
    }

    public function getFullPath()
    {
        return 'public/'.$this->path;
    }
}
