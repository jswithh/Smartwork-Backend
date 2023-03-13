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
        $midyear_evaluationQuery = Midyear_Evaluation::query()->with('goal');

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

    public function update(UpdateMidyear_EvaluationRequest $request, $id)
    {

        $id = Hashids::decode($id)[0];
        $midyear_evaluation = Midyear_Evaluation::find($id);

        if ($midyear_evaluation) {
            $midyear_evaluation->update(
                $request->all()
            );

            return ResponseFormatter::success($midyear_evaluation, 'Midyear_Evaluations Updated');
        }

        return ResponseFormatter::error(null, 'Midyear_Evaluations Failed to Update');
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
