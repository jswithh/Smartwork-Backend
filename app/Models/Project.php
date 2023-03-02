<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'created_by',
        'assigned_to',
        'name',
        'description',
        'tags',
        'start_date',
        'due_date',
        'date_completed',
        'status',
        'priority',
    ];

  

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
