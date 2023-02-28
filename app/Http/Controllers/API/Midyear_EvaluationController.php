<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
Use App\Models\Midyear_Evaluation;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\CreateMidyear_EvaluationRequest;
use App\Http\Requests\UpdateMidyear_EvaluationRequest;
use Illuminate\Http\Request;


class Midyear_EvaluationController extends Controller
{
    public function create(CreateMidyear_EvaluationRequest $request){

        $midyear_evaluation = Midyear_Evaluation::create([
            'user_id' => $request->user_id,
            'goal_id' => $request->goal_id,
            'midyear_realization' => $request->midyear_realization,
            'midyear_manager_comment' => $request->midyear_manager_comment,
        ]);
       

        if($midyear_evaluation){
            return ResponseFormatter::success($midyear_evaluation, 'Midyear_Evaluations Created');
        }

        return ResponseFormatter::error(null, 'Midyear_Evaluations Failed to Create');
}

    public function fetch(Request $request){
        $id = $request->input('id');
        $user_id = $request->input('user_id');
        $limit = $request->input('limit', 10);

        // get multiple data
        $midyear_evaluationQuery = Midyear_Evaluation::query()->with('goal');

        // get single data

        if($id){
            $midyear_evaluation = $midyear_evaluationQuery->find($id);

            if($midyear_evaluation){
                return ResponseFormatter::success($midyear_evaluation, 'Midyear_Evaluations Found');
            }
            return ResponseFormatter::error(null, 'Midyear_Evaluations Not Found');
        }


        if($user_id){
           $midyear_evaluation = $midyear_evaluationQuery->where('user_id', $user_id)->get();

            if($midyear_evaluation){
                return ResponseFormatter::success($midyear_evaluation, 'Midyear_Evaluations Found');
            }
            return ResponseFormatter::error(null, 'Midyear_Evaluations Not Found');
        };

        return ResponseFormatter::success($midyear_evaluationQuery->paginate($limit), 'Midyear_Evaluations Found');

        
    }

    public function update(UpdateMidyear_EvaluationRequest $request, $id){
       

        $midyear_evaluation = Midyear_Evaluation::find($id);

        if($midyear_evaluation){
            $midyear_evaluation->update([
            'user_id' => $request->user_id,
            'goal_id' => $request->goal_id,
            'midyear_realization' => $request->midyear_realization,
            'midyear_manager_comment' => $request->midyear_manager_comment,
            ]
            );

            return ResponseFormatter::success($midyear_evaluation, 'Midyear_Evaluations Updated');
        }

        return ResponseFormatter::error(null, 'Midyear_Evaluations Failed to Update');
    }

    public function delete($id){
        $midyear_evaluation = Midyear_Evaluation::find($id);

        if($midyear_evaluation){
            $midyear_evaluation->delete();

            return ResponseFormatter::success($midyear_evaluation, 'Midyear_Evaluations Deleted');
        }

        return ResponseFormatter::error(null, 'Midyear_Evaluations Failed to Delete');
    }
}
