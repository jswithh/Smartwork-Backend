<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Career_File extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'career_files';

    protected $fillable = [
        'career_id',
        'file_name',
        'size',
        'type',
    ];

    public function career()
    {
        return $this->belongsTo(Career_experience::class);
    }
}
