<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;


class RoleController extends Controller
{
    public function __construct()
    {
         $this->middleware('role:admin');
    }

    public function fetch(Request $request){
        $roles = Role::with('permissions')->get();
        $id = $request->input('id');
       
        if($request->has('id')){
            $id = Hashids::decode($id);
            $roles = Role::with('permissions')->find($id);
            if($roles->isNotEmpty()){
                return ResponseFormatter::success($roles, 'Role list');
            }
            return ResponseFormatter::error('Role not found',404);
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
    $id = Hashids::decode($id)[0];
    $role = Role::find($id);
    if($role){
        $role->name = $request->name;
        $role->guard_name = $request->guard_name == null ? 'web' : $request->guard_name;
        $permissions = explode(',', $request->input('permission'));
        $role->syncPermissions($permissions);
        $role->save();
        return ResponseFormatter::success($role, 'Role updated');
    }
    return ResponseFormatter::error(null, 'Role not updated');
}


    public function delete($id){
        $id = Hashids::decode($id)[0];
        $role = Role::find($id);
        if($role){
            $role->delete();
            return ResponseFormatter::success($role, 'Role deleted');
        }
        return ResponseFormatter::error(null, 'Role not deleted');
    }
}
