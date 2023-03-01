<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEducationFileRequest;
use Illuminate\Http\Request;
use App\Models\Education_File;

class Education_FileController extends Controller
{
    public function create(CreateEducationFileRequest $request)
    {
        try {
             if ($request->hasFile('file_name')) {
                $path = url('/').'/storage/education_file/' . $request->file('file_name')->hashName();
                $request->file('file_name')->store('public/education_file');
            }
            $education_file = Education_File::create([
                'education_id' => $request->education_id,
                'file_name' => $path,
                'size' => $request->size,
                'type' => $request->type,
            ]);

            return ResponseFormatter::success($education_file, 'File created');
        } catch (\Throwable $th) {
            return ResponseFormatter::error($th->getMessage());
        }
    }

    public function fetch(Request $request){

        try {
            $id = $request->id;
            $education_id = $request->education_id;
            
            $education_files = Education_File::query();

            if($id){
                $files = $education_files->find($id);

                if($files){
                    return ResponseFormatter::success($files, 'File Found');
                }
                return ResponseFormatter::error(null,'File not found');
            }

            if($education_id){
                $files = $education_files->where('education_id', $education_id)->get();

                if($files){
                    return ResponseFormatter::success($files, 'File Found');
                }
                return ResponseFormatter::error(null,'File not found');
            }

            return ResponseFormatter::success($education_files, 'File Found');

        } catch (\Throwable $th) {
            return ResponseFormatter::error($th->getMessage());
        }
    }

    public function delete($id){
        try {
            $education_file = Education_File::find($id);

            if($education_file){
                $education_file->delete();
                return ResponseFormatter::success($education_file, 'File Deleted');
            }
            return ResponseFormatter::error(null, 'File not found');
        } catch (\Throwable $th) {
            return ResponseFormatter::error($th->getMessage());
        }
    }
}
