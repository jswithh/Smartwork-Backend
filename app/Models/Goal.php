<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Goal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'strategic_goal',
        'key_performance_indicator',
        'weight',
        'target',
        'due_date',
    ];

    public function employees(){
        return $this->belongsTo(Employee::class);
    }
    
}
