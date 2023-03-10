<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Final_Evaluation;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\CreateFinal_EvaluationRequest;
use App\Http\Requests\UpdateFinal_EvaluationRequest;
use App\Mail\ManagerMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Vinkla\Hashids\Facades\Hashids;

class Final_EvaluationController extends Controller
{
    public function create(CreateFinal_EvaluationRequest $request)
    {

        $final_evaluation = Final_Evaluation::insert($request->all());


        if ($final_evaluation) {
            return ResponseFormatter::success($final_evaluation, 'Final Evaluation Created');
        }

        return ResponseFormatter::error('Final Evaluation Failed to Create', 404);
    }

    public function fetch(Request $request)
    {
        $id = $request->input('id');
        $user_id = $request->input('user_id');
        $limit = $request->input('limit', 10);

        // get multiple data
        $final_evaluationQuery = Final_Evaluation::query()->with(['goal', 'final_evaluation'])->whereYear('created_at', date('Y'));

        // get single data

        if ($request->has('id')) {
            $id = Hashids::decode($id);
            $final_evalution = $final_evaluationQuery->where('id', $id)->get();

            if ($final_evalution->isNotEmpty()) {
                return ResponseFormatter::success($final_evalution, 'Final Evaluation Found');
            }
            return ResponseFormatter::error('Final Evaluation Not Found', 404);
        }


        if ($request->has('user_id')) {
            $user_id = Hashids::decode($user_id);
            $final_evalution = $final_evaluationQuery->where('user_id', $user_id)->get();

            if ($final_evalution->isNotEmpty()) {
                return ResponseFormatter::success($final_evalution, 'Final Evaluation Found');
            }
            return ResponseFormatter::error('Final Evaluation Not Found', 404);
        }

        return ResponseFormatter::success($final_evaluationQuery->paginate($limit), 'Final Evaluation Found');
    }

    public function update(UpdateFinal_EvaluationRequest $request, $user_id)
    {
        $user_id = Hashids::decode($user_id)[0];
        $Final_Evaluations = Final_Evaluation::where('user_id', $user_id)
            ->whereYear('created_at', date('Y'))
            ->where('status', '!=', 'approved')
            ->get();

        $data = $request->all();

        foreach ($Final_Evaluations as $Final_Evaluation) {
            $Final_Evaluation->update($data);
        }
        if ($Final_Evaluation->status == 'send_back') {
            $employee = User::where('id', $Final_Evaluation->user_id)->first();
            Mail::to($employee->email)->send(new ManagerMail($Final_Evaluation));
        }

        if ($Final_Evaluation->status == 'approved') {
            $user = Auth::user();
            $manager = User::where('id', $user->manager_id)->first();
            $employee = User::where('id', $Final_Evaluation->user_id)->first();

            if (!empty($manager)) {
                Mail::to($manager->email)->send(new ManagerMail($Final_Evaluation));
                Mail::to($employee->email)->send(new ManagerMail($Final_Evaluation));
            } else {

                Mail::to($employee->email)->send(new ManagerMail($Final_Evaluation));
            }
        }

        if ($Final_Evaluations) {
            return ResponseFormatter::success($Final_Evaluations, 'Final_Evaluations Updated');
        }
        return ResponseFormatter::error('Final_Evaluations Failed to Update', 404);
    }


    public function delete($id)
    {
        $id = Hashids::decode($id)[0];
        $final_evaluation = Final_Evaluation::find($id);

        if ($final_evaluation) {
            $final_evaluation->delete();

            return ResponseFormatter::success($final_evaluation, 'Final Evaluation Deleted');
        }

        return ResponseFormatter::error('Final Evaluation Failed to Delete', 404);
    }
}
