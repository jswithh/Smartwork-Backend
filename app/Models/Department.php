<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'departments';

    protected $fillable = [
        'name',
        'parent',
        'level',
    ];



    public function users(){
        return $this->hasMany(User::class);
    }

    public function responsibilities(){
        return $this->hasMany(Responsibility::class);
    }

    public function sub_departments(){
        return $this->hasMany(Department::class, 'parent');
    }
}
