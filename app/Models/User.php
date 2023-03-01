<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'hrcode',
        'gender',
        'addres',
        'phone',
        'birthday',
        'birthplace',
        'religion',
        'nationality',
        'education',
        'name_of_school',
        'number_of_identity',
        'place_of_identity',
        'branch',
        'department_id',
        'team_id',
        'job_level',
        'employee_type',
        'profile_photo_path',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

     public function team(){
        return $this->belongsTo(Team::class);
    }

   public function department(){
        return $this->belongsTo(Department::class);
    }

    public function job_level(){
        return $this->belongsTo(Job_Level::class);
    }

    public function salary(){
        return $this->hasOne(Salary::class);
    }

    public function employee_type(){
        return $this->belongsTo(Employee_Type::class);
    }

    public function contract(){
        return $this->hasOne(Contract::class);
    }

    public function insurance(){
        return $this->hasOne(Insurance::class);
    }

    public function attendance(){
        return $this->hasMany(Attendance::class);
    }

    public function user(){
        return $this->hasMany(User::class);
    }

    public function goal(){
        return $this->hasMany(Goal::class);
    }
  
    
}
