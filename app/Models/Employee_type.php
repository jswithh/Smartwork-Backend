<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee_Type extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'employee_types';

    protected $fillable = [
        'name',
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function career_experience()
    {
        return $this->hasMany(Career_experience::class);
    }
}
