<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Career_experience extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'career_experiences';

    protected $fillable = [
        'user_id',
        'company_name',
        'job_title',
        'employee_type_id',
        'location',
        'start_date',
        'end_date',
        'job_description',
    ];

    public function employee_type()
    {
        return $this->belongsTo(Employee_type::class);
    }

    public function career_file()
    {
        return $this->hasMany(Career_File::class);
    }
}
