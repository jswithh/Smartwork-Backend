<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCareerFileRequest;
use Illuminate\Http\Request;
use App\Models\Career_File;
use Vinkla\Hashids\Facades\Hashids;


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
                'career_experience_id' => $request->career_experience_id,
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
            $id = $request->input('id');
            $career_experience_id = $request->input('career_experience_id');
            $career_filesQuery = Career_File::query()->get();

            
        if($request->has('id')){
            $id = Hashids::decode($id);
           
            if($id !== null){
               $career_files = $career_filesQuery->find($id);
            }

            if($career_files->isNotEmpty()){
                return ResponseFormatter::success($career_files, 'Career File Found');
            }
            return ResponseFormatter::error('Career File Not Found',404);
        }

           if($request->has('career_experience_id')){
            $career_experience_id = Hashids::decode($career_experience_id)[0];
           
            if($career_experience_id !== null){
               $career_files = $career_filesQuery->where('career_experience_id', $career_experience_id);
            }

            if($career_files->isNotEmpty()){
                return ResponseFormatter::success($career_files, 'Career File Found');
            }
            return ResponseFormatter::error('Career File Not Found',404);
        }
            return ResponseFormatter::success($career_filesQuery, 'File Found');

        } catch (\Throwable $th) {
            return ResponseFormatter::error($th->getMessage());
        }
    }

    public function delete($id){
        try {
            $id = Hashids::decode($id)[0];
            $career_file = Career_File::find($id);

            if($career_file){
                $career_file->delete();
                return ResponseFormatter::success($career_file, 'File Deleted');
            }
            return ResponseFormatter::error('File not found',404);
        } catch (\Throwable $th) {
            return ResponseFormatter::error($th->getMessage());
        }
    }
}
