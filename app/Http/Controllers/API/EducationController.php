<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
Use App\Models\Education;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\CreateEducationRequest;
use App\Http\Requests\UpdateEducationRequest;
use Illuminate\Http\Request;


class EducationController extends Controller
{
    public function create(CreateEducationRequest $request){

        $education = Education::create([
            'user_id' => $request->user_id,
            'institution_name' => $request->institution_name,
            'degree' => $request->degree,
            'field_of_study' => $request->field_of_study,
            'grade' => $request->grade,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'activities_and_societies' => $request->activities_and_societies,
        ]);
       

        if($education){
            return ResponseFormatter::success($education, 'Education Created');
        }

        return ResponseFormatter::error(null, 'Education Failed to Create');
}

    public function fetch(Request $request){
        $id = $request->input('id');
        $user_id = $request->input('user_id');
        $limit = $request->input('limit', 10);

        // get multiple data
        $educationQuery = Education::query()->with('education_file');

        // get single data

        if($id){
            $education = $educationQuery->find($id);

            if($education){
                return ResponseFormatter::success($education, 'Education Found');
            }
            return ResponseFormatter::error(null, 'Education Not Found');
        }


        if($user_id){
           $education = $educationQuery->where('user_id', $user_id)->get();

            if($education){
                return ResponseFormatter::success($education, 'Education Found');
            }
            return ResponseFormatter::error(null, 'Education Not Found');
        };

        return ResponseFormatter::success($educationQuery->paginate($limit), 'Education Found');

        
    }

    public function update(UpdateEducationRequest $request, $id){
       

        $education = Education::find($id);

        if($education){
            $education->update([
            'user_id' => $request->user_id,
            'institution_name' => $request->institution_name,
            'degree' => $request->degree,
            'field_of_study' => $request->field_of_study,
            'grade' => $request->grade,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'activities_and_societies' => $request->activities_and_societies,
            ]
            );

            return ResponseFormatter::success($education, 'Education Updated');
        }

        return ResponseFormatter::error(null, 'Education Failed to Update');
    }

    public function delete($id){
        $education = Education::find($id);

        if($education){
            $education->delete();

            return ResponseFormatter::success($education, 'Education Deleted');
        }

        return ResponseFormatter::error(null, 'Education Failed to Delete');
    }
}
