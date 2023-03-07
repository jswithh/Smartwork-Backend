<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Permission;


class Role extends Model
{
    use HasFactory, HasRoles;

    protected $table = 'roles';

    protected $fillable = [
        'name',
        'guard_name',
    ];

       public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions', 'role_id', 'permission_id');
    }
  
}
