<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Goal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'strategic_goals',
        'key_performance_indicator',
        'weight',
        'target',
        'status',
        'due_date',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
