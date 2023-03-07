<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserFileRequest;
use Illuminate\Http\Request;
use App\Models\User_File;
use Vinkla\Hashids\Facades\Hashids;

class User_FileController extends Controller
{
    public function create(CreateUserFileRequest $request)
    {
        try {
             if ($request->hasFile('file_name')) {
                $path = url('/').'/storage/user_file/' . $request->file('file_name')->hashName();
                $request->file('file_name')->store('public/user_file');
            }
            $user_file = User_File::create([
                'user_id' => $request->user_id,
                'file_name' => $path,
                'size' => $request->size,
                'type' => $request->type,
            ]);

            return ResponseFormatter::success($user_file, 'File created');
        } catch (\Throwable $th) {
            return ResponseFormatter::error($th->getMessage());
        }
    }

    public function fetch(Request $request){

        try {
            $id = $request->input('id');
            $user_id = $request->user_id;
            
            $user_files = User_File::query()->get();

            if($request->has('id')){
                $id = Hashids::decode($id)[0];
                $user_files->where('id', $id);

                if(!$user_files->isEmpty()){
                    return ResponseFormatter::success($user_files, 'File Found');
                }
                return ResponseFormatter::error('File not found',404);
            }

            if($request->has('user_id')){
                $user_id = Hashids::decode($user_id)[0];
                $user_files->where('user_id', $user_id);

                if(!$user_files->isEmpty()){
                    return ResponseFormatter::success($user_files, 'File Found');
                }
                return ResponseFormatter::error('File not found',404);
            }

            return ResponseFormatter::success($user_files, 'File Found');

        } catch (\Throwable $th) {
            return ResponseFormatter::error($th->getMessage());
        }
    }

    public function delete($id){
        try {
            $id = Hashids::decode($id)[0];
            $user_file = User_File::find($id);

            if($user_file){
                $user_file->delete();
                return ResponseFormatter::success($user_file, 'File Deleted');
            }
            return ResponseFormatter::error(null, 'File not found');
        } catch (\Throwable $th) {
            return ResponseFormatter::error($th->getMessage());
        }
    }
}
