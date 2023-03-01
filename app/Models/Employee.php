<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Employee extends Authenticatable
{
    use HasFactory, SoftDeletes, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'gender',
        'age',
        'phone',
        'photo',
        'team_id',
        'department_id',
        'is_verified',
        'verification_at',
    ];

    public function team(){
        return $this->belongsTo(Team::class);
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }
    
}
