<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Final_Evaluation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'final_evaluations';

    protected $fillable = [
        'user_id',
        'goal_id',
        'midyear_id',
        'final_realization',
        'final_goal_status',
        'final_employee_score',
        'final_manager_score',
        'final_employee_behavior',
        'final_manager_behavior',
        'final_manager_comment',
        'final_employee_comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }

    public function midyear_evaluation()
    {
        return $this->belongsTo(Midyear_Evaluation::class, 'midyear_id');
    }
}
