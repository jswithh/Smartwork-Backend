<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use App\Models\Job_Level;
use App\Helpers\ResponseFormatter;
use Vinkla\Hashids\Facades\Hashids;

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

    public function fetch(Request $request){
        $id = $request->input('id');
        $limit = $request->input('limit', 10);
        $job_level = Job_Level::query();

        if($request->has('id')){
            $id = Hashids::decode($id);
            $job_level = $job_level->where('id', $id)->get();

            if($job_level->isNotEmpty()){
                return ResponseFormatter::success($job_level, 'Job Level Found');
            }
            return ResponseFormatter::error('Job Level Not Found',404);
        }
        return ResponseFormatter::success($job_level->paginate($limit), 'Job Level Fetched');
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => ['required', 'string', 'max:50'],
        ]);

        $id = Hashids::decode($id)[0];
        $job_level = Job_Level::find($id);

        if($job_level){
            $job_level->name = $request->name;
            $job_level->save();

            return ResponseFormatter::success($job_level, 'Job Level Updated');
        }

        return ResponseFormatter::error(null, 'Job Level Failed to Update');
    }

    public function delete($id){
        $id = Hashids::decode($id)[0];
        $job_level = Job_Level::find($id);

        if($job_level){
            $job_level->delete();

            return ResponseFormatter::success($job_level, 'Job Level Deleted');
        }

        return ResponseFormatter::error(null, 'Job Level Failed to Delete');
    }
}
