<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use Illuminate\Http\Request;


class RoleController extends Controller
{
    public function __construct()
    {
         $this->middleware('role:admin');
    }

    public function fetch(Request $request){
        $roles = Role::with('permissions')->get();
        $id = $request->input('id');
       

        if($id){
            $role = $roles->find($id);
            if($role){
                return ResponseFormatter::success($role, 'Role found');
            }
            return ResponseFormatter::error(null, 'Role not found');
        }
        return ResponseFormatter::success($roles, 'Role list'); 
    }

    public function create(CreateRoleRequest $request){
        $role = new Role();
        $role->name = $request->name;
        $role->guard_name = $request->guard_name == null ? 'web' : $request->guard_name;
        $permission = explode(',', $request->input('permission'));
        $role->givePermissionTo($permission);
        $role->save();
        if($role){
            return ResponseFormatter::success($role, 'Role created');
        }

        return ResponseFormatter::error(null, 'Role not created');
    }

    public function update(UpdateRoleRequest $request, $id){
        $role = Role::find($id);
        if($role){
            $role->name = $request->name;
            $role->guard_name = $request->guard_name == null ? 'web' : $request->guard_name;
            $permission = explode(',', $request->input('permission'));
            $role->syncPermissions($permission);
            $role->save();
            return ResponseFormatter::success($role, 'Role updated');
        }
        return ResponseFormatter::error(null, 'Role not updated');
    }

    public function delete($id){
        $role = Role::find($id);
        if($role){
            $role->delete();
            return ResponseFormatter::success($role, 'Role deleted');
        }
        return ResponseFormatter::error(null, 'Role not deleted');
    }
}
