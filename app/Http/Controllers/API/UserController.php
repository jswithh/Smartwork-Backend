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
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'hrcode'=> $request->hrcode,
                'gender'=> $request->gender,
                'address'=> $request->address,
                'phone'=> $request->phone,
                'birthday'=> $request->birthday,
                'birthplace'=> $request->birthplace,
                'religion'=> $request->religion,
                'marital_status',
                'dependent',
                'nationality'=> $request->nationality,
                'education'=> $request->education,
                'name_of_school'=> $request->name_of_school,
                'number_of_identity'=> $request->number_of_identity,
                'place_of_identity'=> $request->place_of_identity,
                'branch'=> $request->branch,
                'department_id'=> $request->department_id,
                'team_id'=> $request->team_id,
                'job_level'=> $request->job_level,
                'employee_type'=> $request->employee_type,
                'profile_photo_path'=> isset($path) ? $path : null,
                'is_active'=> $request->is_active,
            ]);

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
        // Get user
        $user = $request->user();

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

        $userQuery = $user->where('is_active', 1)->with(['department', 'team'])->paginate($limit);

        if ($id){
            $userQuery = User::where('id', $id)->with(['department', 'team'])->first();

            if ($userQuery){

                return ResponseFormatter::success($userQuery, 'Data user berhasil diambil');
            }
            
               return ResponseFormatter::error('Employee not found', 404);
        }

        if($name){
            $userQuery = User::where('name', 'like', '%'.$name.'%')->with(['department', 'team'])->get();

            if($userQuery){
                return ResponseFormatter::success($userQuery, 'Data user berhasil diambil');
            }
            return ResponseFormatter::error('Employee not found', 404);
        }

        if($team_id){
            $userQuery = User::where('team_id', $team_id)->with(['department', 'team'])->get();
            if($userQuery){
                return ResponseFormatter::success($userQuery, 'Data user berhasil diambil');
            }
            return ResponseFormatter::error('Employee not found', 404);
        }

        if($department_id){
            $userQuery = User::where('department_id', $department_id)->with(['department', 'team'])->get();
            if($userQuery){
                return ResponseFormatter::success($userQuery, 'Data user berhasil diambil');
            }
            return ResponseFormatter::error('Employee not found', 404);
        }

        return ResponseFormatter::success(
            $userQuery,
            'Employees found'
        );
    }

    public function deleteUser($id){
        $User = User::find($id);

        if($User){
            $User->delete();
            return ResponseFormatter::success($User, 'User berhasil dihapus');
        }

        return ResponseFormatter::error('User not found', 404);
       
    }

    public function update(UpdateUserRequest $request, $id){
        try {
            $users = User::find($id);
            
            if($users){
                $users->name = $request->name;
                $users->email = $request->email;
                $users->hrcode = $request->hrcode;
                $users->gender = $request->gender;
                $users->addres = $request->addres;
                $users->phone = $request->phone;
                $users->birthday = $request->birthday;
                $users->birthplace = $request->birthplace;
                $users->religion = $request->religion;
                $users->marital_status = $request->marital_status;
                $users->dependent = $request->dependent;
                $users->nationality = $request->nationality;
                $users->education = $request->education;
                $users->name_of_school = $request->name_of_school;
                $users->number_of_identity = $request->number_of_identity;
                $users->place_of_identity = $request->place_of_identity;
                $users->branch = $request->branch;
                $users->department_id = $request->department_id;
                $users->team_id = $request->team_id;
                $users->job_level = $request->job_level;
                $users->employee_type = $request->employee_type;
                $users->is_active = $request->is_active;
                $users->password = Hash::make($request->password);
                $users->save();
        
            }

            return ResponseFormatter::success($users, 'User berhasil diupdate');

        } catch (\Throwable $th) {
            return ResponseFormatter::error($th->getMessage(), 500);
        }
    }

    public function delete($id){
        $users = User::find($id);

        if($users){
            $users->delete();
            return ResponseFormatter::success($users, 'User berhasil dihapus');
        }

        return ResponseFormatter::error('User not found', 404);

    }

 
}
