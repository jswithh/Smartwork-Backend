<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
Use App\Models\Education;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\CreateEducationRequest;
use App\Http\Requests\UpdateEducationRequest;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;


class EducationController extends Controller
{
    public function create(CreateEducationRequest $request){

        $education = Education::create($request->all());
       

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

         if($request->has('id')){
            $id = Hashids::decode($id);
            if($id !== null){
               $education= $educationQuery->where('id', $id)->get();
            }

            if($education->isNotEmpty()){
                return ResponseFormatter::success($education, 'Education Found');
            }
            return ResponseFormatter::error('Education Not Found',404);
        }

             if($request->has('user_id')){
            $user_id = Hashids::decode($user_id);
            if($user_id !== null){
               $education= $educationQuery->where('user_id', $user_id)->get();
            }

            if($education->isNotEmpty()){
                return ResponseFormatter::success($education, 'Education Found');
            }
            return ResponseFormatter::error('Education Not Found',404);
        }

        return ResponseFormatter::success($educationQuery->paginate($limit), 'Education Found');

        
    }

    public function update(UpdateEducationRequest $request, $id){
       
        $id = Hashids::decode($id)[0];
        $education = Education::find($id);

        if($education){
            $education->update($request->all()
            );

            return ResponseFormatter::success($education, 'Education Updated');
        }

        return ResponseFormatter::error(null, 'Education Failed to Update');
    }

    public function delete($id){
        $id = Hashids::decode($id)[0];
        $education = Education::find($id);

        if($education){
            $education->delete();

            return ResponseFormatter::success($education, 'Education Deleted');
        }

        return ResponseFormatter::error(null, 'Education Failed to Delete');
    }
}
