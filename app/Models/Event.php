<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [
        'tittle',
        'event_type',
        'start_date',
        'end_date',
        'time',
        'event_url',
        'user_id',
        'location',
        'description',
    ];
}
