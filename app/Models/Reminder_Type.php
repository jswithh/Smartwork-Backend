<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reminder_Type extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reminder_types';

    protected $fillable = [
        'name',
    ];


}
