<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Midyear_Evaluation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'goal_id',
        'midyear_realization',
        'midyear_manager_comment',
    ];

    public function goals(){
        return $this->belongsTo(Goal::class);
    }
}
