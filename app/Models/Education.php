<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Education extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'educations';

    protected $fillable = [
        'user_id',
        'institution_name',
        'degree',
        'field_of_study',
        'grade',
        'start_date',
        'end_date',
        'activities_and_societies',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function Education_file()
    {
        return $this->hasMany(Education_File::class);
    }

    
}
