<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Vinkla\Hashids\Facades\Hashids;


class UserController extends Controller
{
    public function login(Request $request)
    {
        try {
            // Validate request
            $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            // Find user by email
            $user = User::where('email', $request->email)->firstOrFail();
            if (!Hash::check($request->password, $user->password)) {
                throw new Exception('Invalid password');
            }

            // Generate token
            $tokenResult = $user->createToken('authToken')->plainTextToken;

            // Return response
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'Login success');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function register(CreateUserRequest $request)
    {
        try {
            if($request->file('profile_photo_path')){
                 $path = url('/').'/storage/profile_photo_path/' . $request->file('profile_photo_path')->hashName();
                 $request->file('profile_photo_path')->store('public/profile_photo_path');
            }

            // Create user
            $user = User::create($request->all());

            // Generate token
            $tokenResult = $user->createToken('authToken')->plainTextToken;

            // Return response
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'Register success');
        } catch (Exception $error) {
            // Return error response
            return ResponseFormatter::error($error->getMessage());
        }
    }

    public function logout(Request $request)
    {
        // Revoke Token
        $token = $request->user()->currentAccessToken()->delete();

        // Return response
        return ResponseFormatter::success($token, 'Logout success');
    }

    public function fetch(Request $request)
    {
        // Get user is login
        $user = User::with([
    'department', 
    'team', 
    'User_File', 
    'salary', 
    'education.Education_file',
    'users.career_file',
    'contract',
    'insurance',
])->findOrFail($request->user()->id);


        // Return response
        return ResponseFormatter::success($user, 'Fetch success');
    }
    
    public function getAll(Request $request)
    {
        
        $id = $request->input('id');
        $name = $request->input('name');
        $department_id = $request->input('department_id');
        $team_id = $request->input('team_id');
        $limit = $request->input('limit', 10);
        $user = User::query();

        $userQuery = $user->where('is_active', 1)->with(['department', 'team', 'user_file'])->paginate($limit);

        if($request->has('id')){
            $id = Hashids::decode($id);
            if($id !== null){
               $users = $user->where('id', $id)->with(['department', 'team', 'user_file'])->get();
            }

            if(!$users->isEmpty()){
                return ResponseFormatter::success($users, 'Data user berhasil diambil');
            }                
             return ResponseFormatter::error('User tidak ditemukan', 404);
        }


        if($name){
            $userQuery = User::where('name', 'like', '%'.$name.'%')->with(['department', 'team', 'user_file'])->get();

            if(!$userQuery->isEmpty()){
                return ResponseFormatter::success($userQuery, 'Data user berhasil diambil');
            }
            return ResponseFormatter::error('Employee not found', 404);
        }

       if($request->has('team_id')){
            $team_id = Hashids::decode($team_id);
            if($team_id !== null){
               $users = $user->where('team_id', $team_id)->with(['department', 'team', 'user_file'])->get();
            }

            if(!$users->isEmpty()){
                return ResponseFormatter::success($users, 'Data user berhasil diambil');
            }                
             return ResponseFormatter::error('User tidak ditemukan', 404);
        }

        if($request->has('department_id')){
            $department_id = Hashids::decode($department_id);
            if($department_id !== null){
               $users = $user->where('department_id', $department_id)->with(['department', 'team', 'user_file'])->get();
            }

            if(!$users->isEmpty()){
                return ResponseFormatter::success($users, 'Data user berhasil diambil');
            }                
             return ResponseFormatter::error('User tidak ditemukan', 404);
        }

        return ResponseFormatter::success(
            $userQuery,
            'Employees found'
        );
    }

    public function delete($id){
        $id = Hashids::decode($id)[0];
        $User = User::find($id);

        if($User){
            $User->delete();
            return ResponseFormatter::success($User, 'User berhasil dihapus');
        }

        return ResponseFormatter::error('User not found', 404);
       
    }

    public function update(UpdateUserRequest $request, $id){
        try {
            $id = Hashids::decode($id)[0];
            $users = User::find($id);
            
            if($users){
                $users->update($request->all());
        
            }

            return ResponseFormatter::success($users, 'User berhasil diupdate');

        } catch (\Throwable $th) {
            return ResponseFormatter::error($th->getMessage(), 500);
        }
    }



    public function assignRole(Request $request, $id){
        $id = Hashids::decode($id)[0];
        $user = User::find($id);
        $user->assignRole($request->role);
        $permission = explode(',', $request->input('permission'));
        $user->givePermissionTo($permission);
        return ResponseFormatter::success($user, 'Role berhasil diassign');
    }

    public function updateUserRole(Request $request, $id){
        $id = Hashids::decode($id)[0];
        $users = User::find($id);
        $users->syncRoles($request->role);
        $permission = explode(',', $request->input('permission'));
        $users->syncPermissions($permission);
        return ResponseFormatter::success($users, 'Role berhasil diupdate');
    }

 
}
