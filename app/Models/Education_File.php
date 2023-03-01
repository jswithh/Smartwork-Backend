<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Education_File extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'education_files';

    protected $fillable = [
        'education_id',
        'file_name',
        'size',
        'type',
    ];

    public function education()
    {
        return $this->belongsTo(Education::class, 'education_id');
    }
}
