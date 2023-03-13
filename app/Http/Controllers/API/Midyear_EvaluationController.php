<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Midyear_Evaluation;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\CreateMidyear_EvaluationRequest;
use App\Http\Requests\UpdateMidyear_EvaluationRequest;
use App\Mail\ManagerMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Vinkla\Hashids\Facades\Hashids;

class Midyear_EvaluationController extends Controller
{
    public function create(CreateMidyear_EvaluationRequest $request)
    {

        $midyear_evaluation = Midyear_Evaluation::create($request->all());


        if ($midyear_evaluation) {
            $user = Auth::user();
            $manager = User::where('id', $user->manager_id)->first();
            Mail::to($manager->email)->send(new ManagerMail($user, $manager));
            return ResponseFormatter::success($midyear_evaluation, 'Midyear_Evaluations Created');
        }

        return ResponseFormatter::error(null, 'Midyear_Evaluations Failed to Create');
    }

    public function fetch(Request $request)
    {
        $id = $request->input('id');
        $user_id = $request->input('user_id');
        $limit = $request->input('limit', 10);

        // get multiple data
        $midyear_evaluationQuery = Midyear_Evaluation::query()->with(['user', 'Midyear_Evaluation']);

        // get single data

        if ($request->has('id')) {
            $id = Hashids::decode($id);
            $midyear_evaluation = $midyear_evaluationQuery->where('id', $id)->get();

            if ($midyear_evaluation->isNotEmpty()) {
                return ResponseFormatter::success($midyear_evaluation, 'Midyear_Evaluations Found');
            }
            return ResponseFormatter::error('Midyear_Evaluations Not Found', 404);
        }


        if ($request->has('user_id')) {
            $user_id = Hashids::decode($user_id);
            $midyear_evaluation = $midyear_evaluationQuery->where('user_id', $user_id)->get();

            if ($midyear_evaluation->isNotEmpty()) {
                return ResponseFormatter::success($midyear_evaluation, 'Midyear_Evaluations Found');
            }
            return ResponseFormatter::error('Midyear_Evaluations Not Found', 404);
        }

        $midyear_evaluation = $midyear_evaluationQuery->paginate($limit);
        if ($midyear_evaluation->isNotEmpty()) {
            return ResponseFormatter::success($midyear_evaluation, 'Midyear_Evaluations Found');
        }
        return ResponseFormatter::error('Midyear_Evaluations Not Found', 404);
    }

    public function update(UpdateMidyear_EvaluationRequest $request, $user_id)
    {
        $user_id = Hashids::decode($user_id)[0];
        $Midyear_Evaluations = Midyear_Evaluation::where('user_id', $user_id)
            ->whereYear('created_at', date('Y'))
            ->where('status', '!=', 'approved')
            ->get();

        $data = $request->all();

        foreach ($Midyear_Evaluations as $Midyear_Evaluation) {
            $Midyear_Evaluation->update($data);
        }
        if ($Midyear_Evaluation->status == 'send_back') {
            $employee = User::where('id', $Midyear_Evaluation->user_id)->first();
            Mail::to($employee->email)->send(new ManagerMail($Midyear_Evaluation));
        }

        if ($Midyear_Evaluation->status == 'approved') {
            $user = Auth::user();
            $manager = User::where('id', $user->manager_id)->first();
            $employee = User::where('id', $Midyear_Evaluation->user_id)->first();

            if (!empty($manager)) {
                Mail::to($manager->email)->send(new ManagerMail($Midyear_Evaluation));
                Mail::to($employee->email)->send(new ManagerMail($Midyear_Evaluation));
            } else {

                Mail::to($employee->email)->send(new ManagerMail($Midyear_Evaluation));
            }
        }

        if ($Midyear_Evaluations) {
            return ResponseFormatter::success($Midyear_Evaluations, 'Midyear_Evaluations Updated');
        }
        return ResponseFormatter::error('Midyear_Evaluations Failed to Update', 404);
    }

    public function delete($id)
    {
        $id = Hashids::decode($id)[0];
        $midyear_evaluation = Midyear_Evaluation::find($id);

        if ($midyear_evaluation) {
            $midyear_evaluation->delete();

            return ResponseFormatter::success($midyear_evaluation, 'Midyear_Evaluations Deleted');
        }

        return ResponseFormatter::error(null, 'Midyear_Evaluations Failed to Delete');
    }
}
