<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'department_id',
        'icon',
    ];

   

    public function user(){
        return $this->hasMany(User::class);
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }
    
}
