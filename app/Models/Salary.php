<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Salary extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'salary';

    protected $fillable = [
        'user_id',
        'bank_account_number',
        'bank_name',
        'bank_of_issue',
        'npwp_number',
        'signed_date',
        'sallary_type',
        'sallary_form',
        'amout_sallary',
        'amout_allowance',
        'allowance_type',
        'note',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
