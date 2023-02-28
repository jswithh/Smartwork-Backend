<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
Use App\Models\Goal;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\CreateGoalRequest;
use App\Http\Requests\UpdateGoalRequest;
use Illuminate\Http\Request;


class GoalController extends Controller
{
    public function create(CreateGoalRequest $request){

        $goal = Goal::create([
            'user_id' => $request->user_id,
            'strategic_goals' => $request->strategic_goals,
            'key_performance_indicator' => $request->key_performance_indicator,
            'weight' => $request->weight,
            'target' => $request->target,
            'due_date' => $request->due_date,
        ]);
       

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

        if($id){
            $goal = $goalQuery->find($id);

            if($goal){
                return ResponseFormatter::success($goal, 'Goals Found');
            }
            return ResponseFormatter::error(null, 'Goals Not Found');
        }


        if($user_id){
           $goal = $goalQuery->where('user_id', $user_id)->get();

            if($goal){
                return ResponseFormatter::success($goal, 'Goals Found');
            }
            return ResponseFormatter::error(null, 'Goals Not Found');
        };

        return ResponseFormatter::success($goalQuery->paginate($limit), 'Goals Found');

        
    }

    public function update(UpdateGoalRequest $request, $id){
       

        $goal = Goal::find($id);

        if($goal){
            $goal->update([
           'user_id' => $request->user_id,
            'strategic_goals' => $request->strategic_goals,
            'key_performance_indicator' => $request->key_performance_indicator,
            'weight' => $request->weight,
            'target' => $request->target,
            'due_date' => $request->due_date,
            ]
            );

            return ResponseFormatter::success($goal, 'Goals Updated');
        }

        return ResponseFormatter::error(null, 'Goals Failed to Update');
    }

    public function delete($id){
        $goal = Goal::find($id);

        if($goal){
            $goal->delete();

            return ResponseFormatter::success($goal, 'Goals Deleted');
        }

        return ResponseFormatter::error(null, 'Goals Failed to Delete');
    }
}
