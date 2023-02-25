<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Insurance extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'insurance_type',
        'insurance_number',
        'secondary_insurance_type',
        'secondary_insurance_number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
