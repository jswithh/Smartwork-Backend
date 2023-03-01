<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserFileRequest;
use Illuminate\Http\Request;
use App\Models\User_File;

class User_FileController extends Controller
{
    public function create(CreateUserFileRequest $request)
    {
        try {
            if($request->file('file_name')){
                 $path = url('/').'/storage/file_name/' . $request->file('file_name')->hashName();
                 $request->file('file_name')->store('public/file_name');
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
            $id = $request->id;
            $user_id = $request->user_id;
            
            $user_files = User_File::query();

            if($id){
                $files = $user_files->find($id);

                if($files){
                    return ResponseFormatter::success($files, 'File Found');
                }
                return ResponseFormatter::error(null,'File not found');
            }

            if($user_id){
                $files = $user_files->where('user_id', $user_id)->get();

                if($files){
                    return ResponseFormatter::success($files, 'File Found');
                }
                return ResponseFormatter::error(null,'File not found');
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
