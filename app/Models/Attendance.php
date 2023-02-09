<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'clock_in',
        'clock_out',
        'working_from',
        'late',
        'clock_out_address',
        'working_hours',
        'break_in',
        'break_out',
        'break_hours',
        'totally',
        'overtime',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
