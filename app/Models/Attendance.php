<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'clock_in_time',
        'clock_out_time',
        'working_from',
        'late',
        'clock_out_addres',
        'working_hours',
        'break_in',
        'break_out',
        'break_hours',
        'Totally',
        'Overtime',
    ];

   public function user()
   {
       return $this->belongsTo(User::class);
   }
}
