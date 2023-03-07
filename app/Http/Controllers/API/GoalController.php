<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
Use App\Models\Goal;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\CreateGoalRequest;
use App\Http\Requests\UpdateGoalRequest;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class GoalController extends Controller
{
    public function create(CreateGoalRequest $request){

        $goal = Goal::create($request->all());
       

        if($goal){
            return ResponseFormatter::success($goal, 'Goals Created');
        }

        return ResponseFormatter::error(null, 'Goals Failed to Create');
}

    public function fetch(Request $request){
        $id = $request->input('id');
        $user_id = $request->input('user_id');
        $limit = $request->input('limit', 10);

        // get multiple data
        $goalQuery = Goal::query();

        // get single data

        if($request->has('id')){
            $id = Hashids::decode($id);
            $goal = $goalQuery->where('id', $id)->get();

            if($goal->isNotEmpty()){
                return ResponseFormatter::success($goal, 'Goals Found');
            }
            return ResponseFormatter::error('Goals Not Found',404);
        }

        if($request->has('user_id')){
            $user_id = Hashids::decode($user_id);
            $goal = $goalQuery->where('user_id', $user_id)->get();

            if($goal->isNotEmpty()){
                return ResponseFormatter::success($goal, 'Goals Found');
            }
            return ResponseFormatter::error('Goals Not Found',404);
        }

        return ResponseFormatter::success($goalQuery->paginate($limit), 'Goals Found');

        
    }

    public function update(UpdateGoalRequest $request, $id){
       
        $id = Hashids::decode($id)[0];
        $goal = Goal::find($id);

        if($goal){
            $goal->update($request->all()
            );

            return ResponseFormatter::success($goal, 'Goals Updated');
        }

        return ResponseFormatter::error(null, 'Goals Failed to Update');
    }

    public function delete($id){
        $id = Hashids::decode($id)[0];
        $goal = Goal::find($id);

        if($goal){
            $goal->delete();

            return ResponseFormatter::success($goal, 'Goals Deleted');
        }

        return ResponseFormatter::error(null, 'Goals Failed to Delete');
    }
}
