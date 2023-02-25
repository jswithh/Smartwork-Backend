<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'contracts';

    protected $fillable = [
        'user_id',
        'employee_type_id',
        'contract_status',
        'contract_start_date',
        'contract_end_date',
    ];

     public function employee_type()
    {
        return $this->belongsTo(Employee_type::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

