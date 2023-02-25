<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use App\Models\Job_Level;
use App\Helpers\ResponseFormatter;


class Job_LevelController extends Controller
{
    public function create(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:50'],
        ]);

        $job_level = Job_Level::create([
            'name' => $request->name,
        ]);

        if($job_level){
            return ResponseFormatter::success($job_level, 'Job Level Created');
        }

        return ResponseFormatter::error(null, 'Job Level Failed to Create');
}

    public function fetch(){
        $job_level = Job_Level::all();

        if($job_level){
            return ResponseFormatter::success($job_level, 'Job Level Fetched');
        }

        return ResponseFormatter::error(null, 'Job Level Failed to Fetch');
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => ['required', 'string', 'max:50'],
        ]);

        $job_level = Job_Level::find($id);

        if($job_level){
            $job_level->name = $request->name;
            $job_level->save();

            return ResponseFormatter::success($job_level, 'Job Level Updated');
        }

        return ResponseFormatter::error(null, 'Job Level Failed to Update');
    }

    public function delete($id){
        $job_level = Job_Level::find($id);

        if($job_level){
            $job_level->delete();

            return ResponseFormatter::success($job_level, 'Job Level Deleted');
        }

        return ResponseFormatter::error(null, 'Job Level Failed to Delete');
    }
}
