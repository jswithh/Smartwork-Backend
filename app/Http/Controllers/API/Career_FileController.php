<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCareerFileRequest;
use Illuminate\Http\Request;
use App\Models\Career_File;

class Career_FileController extends Controller
{
    public function create(CreateCareerFileRequest $request)
    {
        try {
             if ($request->hasFile('file_name')) {
                $path = url('/').'/storage/career_file/' . $request->file('file_name')->hashName();
                $request->file('file_name')->store('public/career_file');
            }
            $career_file = Career_File::create([
                'career_id' => $request->career_id,
                'file_name' => $path,
                'size' => $request->size,
                'type' => $request->type,
            ]);

            return ResponseFormatter::success($career_file, 'File created');
        } catch (\Throwable $th) {
            return ResponseFormatter::error($th->getMessage());
        }
    }

    public function fetch(Request $request){

        try {
            $id = $request->id;
            $career_id = $request->career_id;
            
            $career_files = Career_File::query();

            if($id){
                $files = $career_files->find($id);

                if($files){
                    return ResponseFormatter::success($files, 'File Found');
                }
                return ResponseFormatter::error(null,'File not found');
            }

            if($career_id){
                $files = $career_files->where('career_id', $career_id)->get();

                if($files){
                    return ResponseFormatter::success($files, 'File Found');
                }
                return ResponseFormatter::error(null,'File not found');
            }

            return ResponseFormatter::success($career_files, 'File Found');

        } catch (\Throwable $th) {
            return ResponseFormatter::error($th->getMessage());
        }
    }

    public function delete($id){
        try {
            $career_file = Career_File::find($id);

            if($career_file){
                $career_file->delete();
                return ResponseFormatter::success($career_file, 'File Deleted');
            }
            return ResponseFormatter::error(null, 'File not found');
        } catch (\Throwable $th) {
            return ResponseFormatter::error($th->getMessage());
        }
    }
}
