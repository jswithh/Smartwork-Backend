<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Rules\Password;

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

    public function register(Request $request)
    {
        try {
            // Validate request
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', new Password],
                'hrcode' => ['nullable', 'string', 'unique:users' ],
                'gender' => 'nullable|string|in:MALE,FEMALE',
                'addres' => ['nullable', 'string' ],
                'phone' => ['nullable', 'string' ],
                'birthday' => ['nullable', 'dateTime' ],
                'birthplace' => ['nullable', 'string' ],
                'religion' => ['nullable', 'string' ],
                'nationality' => ['nullable', 'string' ],
                'education' => ['nullable', 'string' ],
                'name_of_school' => ['nullable', 'string' ],
                'number_of_identity' => ['nullable', 'integer' ],
                'place_of_identity' => ['nullable', 'string' ],
                'branch' => ['nullable', 'string' ],
                'role_id' => ['required', 'integer' ],
                'team_id' => ['required', 'string' ],
                'job_level' => ['nullable', 'string' ],
                'employee_type' => ['nullable', 'string' ],
                'profile_photo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'is_active' => ['nullable', 'boolean' ],


            ]);

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
                'nationality'=> $request->nationality,
                'education'=> $request->education,
                'name_of_school'=> $request->name_of_school,
                'number_of_identity'=> $request->number_of_identity,
                'place_of_identity'=> $request->place_of_identity,
                'branch'=> $request->branch,
                'role_id'=> $request->role_id,
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
        $role_id = $request->input('role_id');
        $team_id = $request->input('team_id');
        $limit = $request->input('limit', 10);
        $user = User::query();

        $userQuery = $user->where('is_active', 1)->with(['role', 'team'])->paginate($limit);

        if ($id){
            $userQuery = User::where('id', $id)->with(['role', 'team'])->first();

            if ($userQuery){

                return ResponseFormatter::success($userQuery, 'Data user berhasil diambil');
            }
            
               return ResponseFormatter::error('Employee not found', 404);
        }

        if($name){
            $userQuery = User::where('name', 'like', '%'.$name.'%')->with(['role', 'team'])->get();

            if($userQuery){
                return ResponseFormatter::success($userQuery, 'Data user berhasil diambil');
            }
            return ResponseFormatter::error('Employee not found', 404);
        }

        if($team_id){
            $userQuery = User::where('team_id', $team_id)->with(['role', 'team'])->get();
            if($userQuery){
                return ResponseFormatter::success($userQuery, 'Data user berhasil diambil');
            }
            return ResponseFormatter::error('Employee not found', 404);
        }

        if($role_id){
            $userQuery = User::where('role_id', $role_id)->with(['role', 'team'])->get();
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
}
