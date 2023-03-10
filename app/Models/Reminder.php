<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reminder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'reminder_type_id',
        'created_by',
        'assigned_to',
        'subject',
        'description',
        'date_added',
        'time',
        'adress',
        'url',
        'start_period',
        'end_period',
        'repeat_interval',
        'repeat_unit',
        'next_reminder_date',
        'status',
    ];

    public function reminder_type()
    {
        return $this->belongsTo(Reminder_Type::class);
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assigned_to()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
