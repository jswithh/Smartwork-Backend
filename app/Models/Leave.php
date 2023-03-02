<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Leave extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'approver_id',
        'handover_id',
        'subject',
        'start_date',
        'end_date',
        'reason',
        'number_of_days',
        'leave_type',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class);
    }

    public function handover()
    {
        return $this->belongsTo(User::class);
    }
}
