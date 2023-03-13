<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Goal;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\CreateGoalRequest;
use App\Http\Requests\UpdateGoalRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Mail;
use App\Mail\ManagerMail;


class GoalController extends Controller
{
    public function create(CreateGoalRequest $request)
    {
        $data = $request->all();

        $goal = Goal::insert($data);

        if ($goal) {
            $user = Auth::user();
            $manager = User::where('id', $user->manager_id)->first();

            Mail::to($manager->email)->send(new ManagerMail($user, $manager));
            return ResponseFormatter::success($data, 'Goals Created');
        }
        return ResponseFormatter::error('Goals Failed to Create', 404);
    }

    public function fetch(Request $request)
    {
        $id = $request->input('id');
        $user_id = $request->input('user_id');
        $limit = $request->input('limit', 10);

        // get multiple data with year now

        $goalQuery = Goal::query()->with(['user', 'midyear_evaluation', 'final_evaluation'])->whereYear('created_at', date('Y'));

        // get single data

        if ($request->has('id')) {
            $id = Hashids::decode($id);
            $goal = $goalQuery->where('id', $id)->get();

            if ($goal->isNotEmpty()) {
                return ResponseFormatter::success($goal, 'Goals Found');
            }
            return ResponseFormatter::error('Goals Not Found', 404);
        }

        if ($request->has('user_id')) {
            $user_id = Hashids::decode($user_id);
            $goal = $goalQuery->where('user_id', $user_id)->get();

            if ($goal->isNotEmpty()) {
                return ResponseFormatter::success($goal, 'Goals Found');
            }
            return ResponseFormatter::error('Goals Not Found', 404);
        }

        return ResponseFormatter::success($goalQuery->paginate($limit), 'Goals Found');
    }

    public function update(UpdateGoalRequest $request, $user_id)
    {
        $user_id = Hashids::decode($user_id)[0];
        $goals = Goal::where('user_id', $user_id)
            ->whereYear('created_at', date('Y'))
            ->where('status', '!=', 'approved')
            ->get();

        $data = $request->all();

        foreach ($goals as $goal) {
            $goal->update($data);
        }
        if ($goal->status == 'send_back') {
            $employee = User::where('id', $goal->user_id)->first();
            Mail::to($employee->email)->send(new ManagerMail($goal));
        }

        if ($goal->status == 'approved') {
            $user = Auth::user();
            $manager = User::where('id', $user->manager_id)->first();
            $employee = User::where('id', $goal->user_id)->first();

            if (!empty($manager)) {
                Mail::to($manager->email)->send(new ManagerMail($goal));
                Mail::to($employee->email)->send(new ManagerMail($goal));
            } else {

                Mail::to($employee->email)->send(new ManagerMail($goal));
            }
        }

        if ($goals) {
            return ResponseFormatter::success($goals, 'Goals Updated');
        }
        return ResponseFormatter::error('Goals Failed to Update', 404);
    }
    public function delete($id)
    {
        $id = Hashids::decode($id)[0];
        $goal = Goal::find($id);

        if ($goal) {
            $goal->delete();

            return ResponseFormatter::success($goal, 'Goals Deleted');
        }

        return ResponseFormatter::error(null, 'Goals Failed to Delete');
    }
}
