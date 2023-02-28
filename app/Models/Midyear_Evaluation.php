<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Midyear_Evaluation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'midyear_evaluations';

    protected $fillable = [
        'user_id',
        'goal_id',
        'midyear_realization',
        'midyear_manager_comment',
    ];

    public function goal(){
        return $this->belongsTo(Goal::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
