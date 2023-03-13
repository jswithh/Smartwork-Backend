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
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use Carbon\Carbon;

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
            $user = User::where('email', $request->email)->with(
                [
                    'department',
                    'team',
                    'User_File',
                    'salary',
                    'education.Education_file',
                    'career_experience.career_file',
                    'contract',
                    'insurance',
                ]
            )->firstOrFail();
            // fetch all user permission
            $user->getAllPermissions();


            if (!Hash::check($request->password, $user->password)) {
                throw new Exception('Invalid password');
            }

            // Generate token
            $tokenResult = $user->createToken('authToken')->plainTextToken;

            // Return response
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 'Login success');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function register(CreateUserRequest $request)
    {
        try {
            if ($request->file('profile_photo_path')) {
                $path = url('/') . '/storage/profile_photo_path/' . $request->file('profile_photo_path')->hashName();
                $request->file('profile_photo_path')->store('public/profile_photo_path');
                $data['profile_photo_path'] = $path;
            }

            // Create user
            $data = $request->all();
            // make ternary operator for password
            $data['password'] = Hash::make('Smartwork123#');
            if (!$request->file('profile_photo_path')) {
                $data['profile_photo_path'] = 'https://ui-avatars.com/api/?name=' . $data['name'] . '&color=7F9CF5&background=EBF4FF';
            };

            $user = User::create($data);

            // Generate token
            $tokenResult = $user->createToken('authToken')->plainTextToken;

            // Send email
            $email = $data['email'];
            $password = 'Smartwork123#';
            Mail::to($email)->send(new WelcomeMail($email, $password));

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
            'career_experience.career_file',
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

        $users = User::query();

        if ($request->has('id')) {
            $id = Hashids::decode($id);
            if ($id !== null) {
                $users->where('id', $id);
            } else {
                return ResponseFormatter::error('User tidak ditemukan', 404);
            }
        }

        if ($name) {
            $users->where('name', 'like', '%' . $name . '%');
        }

        if ($request->has('team_id')) {
            $team_id = Hashids::decode($team_id);
            if ($team_id !== null) {
                $users->where('team_id', $team_id);
            } else {
                return ResponseFormatter::error('User tidak ditemukan', 404);
            }
        }

        if ($request->has('department_id')) {
            $department_id = Hashids::decode($department_id);
            if ($department_id !== null) {
                $users->where('department_id', $department_id);
            } else {
                return ResponseFormatter::error('User tidak ditemukan', 404);
            }
        }

        $users = $users->with(['department', 'team', 'user_file'])->paginate($limit);

        // Hitung age dan tambahkan pada setiap item user
        $users->getCollection()->transform(function ($user) {
            $user['age'] = Carbon::parse($user['birthday'])->age;
            return $user;
        });

        return ResponseFormatter::success($users, 'Data user berhasil diambil');
    }


    public function delete($id)
    {
        $id = Hashids::decode($id)[0];
        $User = User::find($id);

        if ($User) {
            $User->delete();
            return ResponseFormatter::success($User, 'User berhasil dihapus');
        }

        return ResponseFormatter::error('User not found', 404);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $id = Hashids::decode($id)[0];
            $users = User::find($id);

            if ($request->file('profile_photo_path')) {
                $path = url('/') . '/storage/profile_photo_path/' . $request->file('profile_photo_path')->hashName();
                $request->file('profile_photo_path')->store('public/profile_photo_path');
                $data['profile_photo_path'] = $path;
            }

            if (!$request->file('profile_photo_path')) {
                $data['profile_photo_path'] = 'https://ui-avatars.com/api/?name=' . $data['name'] . '&color=7F9CF5&background=EBF4FF';
            };

            $data = $request->all();


            if ($users) {
                $users->update($data);
            }

            return ResponseFormatter::success($users, 'User berhasil diupdate');
        } catch (\Throwable $th) {
            return ResponseFormatter::error($th->getMessage(), 500);
        }
    }



    public function assignRole(Request $request, $id)
    {
        $id = Hashids::decode($id)[0];
        $user = User::find($id);
        $user->assignRole($request->role);
        $permission = explode(',', $request->input('permission'));
        $user->givePermissionTo($permission);
        return ResponseFormatter::success($user, 'Role berhasil diassign');
    }

    public function updateUserRole(Request $request, $id)
    {
        $id = Hashids::decode($id)[0];
        $users = User::find($id);
        $users->syncRoles($request->role);
        $permission = explode(',', $request->input('permission'));
        $users->syncPermissions($permission);
        return ResponseFormatter::success($users, 'Role berhasil diupdate');
    }
}
