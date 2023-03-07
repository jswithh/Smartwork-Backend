<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
Use App\Models\Final_Evaluation;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\CreateFinal_EvaluationRequest;
use App\Http\Requests\UpdateFinal_EvaluationRequest;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class Final_EvaluationController extends Controller
{
    public function create(CreateFinal_EvaluationRequest $request){

        $final_evaluation = Final_Evaluation::create($request->all());
       

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

        if($request->has('id')){
            $id = Hashids::decode($id);
            $final_evalution = $final_evaluationQuery->where('id', $id)->get();

            if($final_evalution->isNotEmpty()){
                return ResponseFormatter::success($final_evalution, 'Final Evaluation Found');
            }
            return ResponseFormatter::error('Final Evaluation Not Found',404);
        }


        if($request->has('user_id')){
            $user_id = Hashids::decode($user_id);
            $final_evalution = $final_evaluationQuery->where('user_id', $user_id)->get();

            if($final_evalution->isNotEmpty()){
                return ResponseFormatter::success($final_evalution, 'Final Evaluation Found');
            }
            return ResponseFormatter::error('Final Evaluation Not Found',404);
        }

        return ResponseFormatter::success($final_evaluationQuery->paginate($limit), 'Final Evaluation Found');

        
    }

    public function update(UpdateFinal_EvaluationRequest $request, $id){
       
        $id = Hashids::decode($id)[0];
        $final_evaluation = Final_Evaluation::find($id);

        if($final_evaluation){
            $final_evaluation->update($request->all()
            );

            return ResponseFormatter::success($final_evaluation, 'Final Evaluation Updated');
        }

        return ResponseFormatter::error('Final Evaluation Failed to Update', 404);
    }

    public function delete($id){
        $id = Hashids::decode($id)[0];
        $final_evaluation = Final_Evaluation::find($id);

        if($final_evaluation){
            $final_evaluation->delete();

            return ResponseFormatter::success($final_evaluation, 'Final Evaluation Deleted');
        }

        return ResponseFormatter::error('Final Evaluation Failed to Delete',404);
    }
}
