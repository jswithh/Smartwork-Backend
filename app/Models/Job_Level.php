<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job_Level extends Model
{
    use HasFactory, SoftDeletes;

        protected $table = 'job_levels';

    protected $fillable = [
        'name',
    ];

    public function User(){
        return $this->hasOne(User::class);
    }
}
