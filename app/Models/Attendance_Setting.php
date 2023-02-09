<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance_Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'office_start_time',
        'office_end_time',
        'late_after',
    ];
}
