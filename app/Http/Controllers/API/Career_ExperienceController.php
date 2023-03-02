<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
Use App\Models\Career_experience;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\CreateCareer_experienceRequest;
use App\Http\Requests\UpdateCareer_experienceRequest;
use Illuminate\Http\Request;


class Career_ExperienceController extends Controller
{
    public function create(CreateCareer_experienceRequest $request){

        $career_experience = Career_experience::create([
            'user_id' => $request->user_id,
            'company_name' => $request->company_name,
            'location' => $request->location,
            'job_title' => $request->job_title,
            'employee_type_id' => $request->employee_type_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'job_description' => $request->job_description,
        ]);
       

        if($career_experience){
            return ResponseFormatter::success($career_experience, 'Career experience Created');
        }

        return ResponseFormatter::error(null, 'Career experience Failed to Create');
}

    public function fetch(Request $request){
        $id = $request->input('id');
        $user_id = $request->input('user_id');
        $limit = $request->input('limit', 10);

        // get multiple data
        $career_experienceQuery = Career_experience::query()->with(['employee_type', 'career_file']);

        // get single data

        if($id){
            $career_experience = $career_experienceQuery->find($id)->with('employee_type');

            if($career_experience){
                return ResponseFormatter::success($career_experience, 'Career experience Found');
            }
            return ResponseFormatter::error(null, 'Career experience Not Found');
        }


        if($user_id){
           $career_experience = $career_experienceQuery->where('user_id', $user_id)->get();

            if($career_experience){
                return ResponseFormatter::success($career_experience, 'Career experience Found');
            }
            return ResponseFormatter::error(null, 'Career experience Not Found');
        };

        return ResponseFormatter::success($career_experienceQuery->paginate($limit), 'Career experience Found');

        
    }

    public function update(UpdateCareer_experienceRequest $request, $id){
       

        $career_experience = Career_experience::find($id);

        if($career_experience){
            $career_experience->update([
            'user_id' => $request->user_id,
            'company_name' => $request->company_name,
            'location' => $request->location,
            'job_title' => $request->job_title,
            'employee_type_id' => $request->employee_type_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'job_description' => $request->job_description,
            ]
            );

            return ResponseFormatter::success($career_experience, 'Career experience Updated');
        }

        return ResponseFormatter::error(null, 'Career experience Failed to Update');
    }

    public function delete($id){
        $career_experience = Career_experience::find($id);

        if($career_experience){
            $career_experience->delete();

            return ResponseFormatter::success($career_experience, 'Career experience Deleted');
        }

        return ResponseFormatter::error(null, 'Career experience Failed to Delete');
    }
}
