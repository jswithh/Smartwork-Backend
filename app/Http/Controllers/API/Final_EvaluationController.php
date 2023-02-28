<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
Use App\Models\Final_Evaluation;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\CreateFinal_EvaluationRequest;
use App\Http\Requests\UpdateFinal_EvaluationRequest;
use Illuminate\Http\Request;


class Final_EvaluationController extends Controller
{
    public function create(CreateFinal_EvaluationRequest $request){

        $final_evaluation = Final_Evaluation::create([
            'user_id' => $request->user_id,
            'goal_id' => $request->goal_id,
            'midyear_id' => $request->midyear_id,
            'final_realization' => $request->final_realization,
            'final_goal_status' => $request->final_goal_status,
            'final_employee_score' => $request->final_employee_score,
            'final_manager_score' => $request->final_manager_score,
            'final_employee_behavior' => $request->final_employee_behavior,
            'final_manager_behavior' => $request->final_manager_behavior,
            'final_manager_comment' => $request->final_manager_comment,
            'final_employee_comment' => $request->final_employee_comment,
        ]);
       

        if($final_evaluation){
            return ResponseFormatter::success($final_evaluation, 'Final Evaluation Created');
        }

        return ResponseFormatter::error(null, 'Final Evaluation Failed to Create');
}

    public function fetch(Request $request){
        $id = $request->input('id');
        $user_id = $request->input('user_id');
        $limit = $request->input('limit', 10);

        // get multiple data
        $final_evaluationQuery = Final_Evaluation::query()->with(['goal', 'midyear_evaluation']);

        // get single data

        if($id){
            $final_evaluation = $final_evaluationQuery->find($id);

            if($final_evaluation){
                return ResponseFormatter::success($final_evaluation, 'Final Evaluation Found');
            }
            return ResponseFormatter::error(null, 'Final Evaluation Not Found');
        }


        if($user_id){
           $final_evaluation = $final_evaluationQuery->where('user_id', $user_id)->get();

            if($final_evaluation){
                return ResponseFormatter::success($final_evaluation, 'Final Evaluation Found');
            }
            return ResponseFormatter::error(null, 'Final Evaluation Not Found');
        };

        return ResponseFormatter::success($final_evaluationQuery->paginate($limit), 'Final Evaluation Found');

        
    }

    public function update(UpdateFinal_EvaluationRequest $request, $id){
       

        $final_evaluation = Final_Evaluation::find($id);

        if($final_evaluation){
            $final_evaluation->update([
            'user_id' => $request->user_id,
            'goal_id' => $request->goal_id,
            'midyear_id' => $request->midyear_id,
            'final_realization' => $request->final_realization,
            'final_goal_status' => $request->final_goal_status,
            'final_employee_score' => $request->final_employee_score,
            'final_manager_score' => $request->final_manager_score,
            'final_employee_behavior' => $request->final_employee_behavior,
            'final_manager_behavior' => $request->final_manager_behavior,
            'final_manager_comment' => $request->final_manager_comment,
            'final_employee_comment' => $request->final_employee_comment,
            ]
            );

            return ResponseFormatter::success($final_evaluation, 'Final Evaluation Updated');
        }

        return ResponseFormatter::error(null, 'Final Evaluation Failed to Update');
    }

    public function delete($id){
        $final_evaluation = Final_Evaluation::find($id);

        if($final_evaluation){
            $final_evaluation->delete();

            return ResponseFormatter::success($final_evaluation, 'Final Evaluation Deleted');
        }

        return ResponseFormatter::error(null, 'Final Evaluation Failed to Delete');
    }
}
