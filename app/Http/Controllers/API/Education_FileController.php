<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEducationFileRequest;
use Illuminate\Http\Request;
use App\Models\Education_File;
use Vinkla\Hashids\Facades\Hashids;

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
            $id = $request->input('id');
            $education_id = $request->input('education_id');
            
            $education_filesQuery = Education_File::query();

              if($request->has('id')){
                $id = Hashids::decode($id);
            if($id !== null){
               $education_files = $education_filesQuery->where('id', $id)->get();
            }

            if($education_files->isNotEmpty()){
                return ResponseFormatter::success($education_files, 'Education file Found');
            }
            return ResponseFormatter::error('Education file Not Found', 404);
        }

        if($request->has('education_id')){
                $education_id = Hashids::decode($education_id);
            if($education_id !== null){
               $education_files = $education_filesQuery->where('education_id', $education_id)->get();
            }

            if($education_files->isNotEmpty()){
                return ResponseFormatter::success($education_files, 'Education file Found');
            }
            return ResponseFormatter::error('Education file Not Found',404);
        }
            return ResponseFormatter::success($education_filesQuery->get(), 'File Found');

        } catch (\Throwable $th) {
            return ResponseFormatter::error($th->getMessage());
        }
    }

    public function delete($id){
        try {
            $id = Hashids::decode($id)[0];
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
