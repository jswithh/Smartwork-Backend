<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
Use App\Models\Career_experience;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\CreateCareer_experienceRequest;
use App\Http\Requests\UpdateCareer_experienceRequest;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
class Career_ExperienceController extends Controller
{
    public function create(CreateCareer_experienceRequest $request){

        $career_experience = Career_experience::create($request->all());
       

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

        if($request->has('id')){
            $id = Hashids::decode($id);
            if($id !== null){
               $career_experience= $career_experienceQuery->where('id', $id)->get();
            }

            if($career_experience->isNotEmpty()){
                return ResponseFormatter::success($career_experience, 'Career experience Found');
            }
            return ResponseFormatter::error('Career experience Not Found', 404);
        }


      if($request->has('user_id')){
            $user_id = Hashids::decode($user_id);
            if($user_id !== null){
               $career_experience= $career_experienceQuery->where('user_id', $user_id)->get();
            }

            if($career_experience->isNotEmpty()){
                return ResponseFormatter::success($career_experience, 'Career experience Found');
            }
            return ResponseFormatter::error('Career experience Not Found', 404);
        }

        return ResponseFormatter::success($career_experienceQuery->paginate($limit), 'Career experience List');

        
    }

    public function update(UpdateCareer_experienceRequest $request, $id){

       
        $id = Hashids::decode($id)[0];
        $career_experience = Career_experience::find($id);

        if($career_experience){
            $career_experience->update($request->all()
            );

            return ResponseFormatter::success($career_experience, 'Career experience Updated');
        }

        return ResponseFormatter::error(null, 'Career experience Failed to Update');
    }

    public function delete($id){
        $id = Hashids::decode($id)[0];
        $career_experience = Career_experience::find($id);

        if($career_experience){
            $career_experience->delete();

            return ResponseFormatter::success($career_experience, 'Career experience Deleted');
        }

        return ResponseFormatter::error('Career experience Failed to Delete',404);
    }
}
