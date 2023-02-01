<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\ResponseFormatter;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Rules\Password;

class UserController extends Controller
{
   public function login(Request $request){
     try {

        // Validasi input
        $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);
        
        // Cek credentials (login)
        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials)){
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'Authentication Failed', 401);
        }

        $user = User::where('email', $request->email)->first();
        if(!Hash::check($request->password, $user->password, [])){
            throw new \Exception('Invalid Password');
        }

        // generate token
        $tokenResult = $user->createToken('authToken')->plainTextToken;

        // return response
        return ResponseFormatter::success([
            'access_token' => $tokenResult,
            'token_type' => 'Bearer',
            'user' => $user
        ], 'Logged in successfully');
        
    } catch (Exception $e) {
        return ResponseFormatter::error([
            'message' => 'Authentication Failed',
            'error' => $e
        ], 'Authentication Failed', 500);
    }
   }

   public function register(Request $request){
         try {
              $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', new Password]
              ]);
    
              $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
              ]);
    
    
              // generate token
              $tokenResult = $user->createToken('authToken')->plainTextToken;
    
              // return response
              return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
              ], 'Registered successfully');
         } catch (Exception $e) {
              return ResponseFormatter::error([
                'message' => 'Authentication Failed',
                'error' => $e
              ], 'Authentication Failed', 500);
         }
   }

   public function logout(Request $request){
    // Revoke current token
        $token = $request->user()->currentAccessToken()->delete();
        return ResponseFormatter::success($token, 'Token Revoked');
   }

   public function fetch(Request $request){
    return ResponseFormatter::success($request->user(), 'Data profile user berhasil diambil');
   }
}
