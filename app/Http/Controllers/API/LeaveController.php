<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
Use App\Models\Leave;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\CreateLeaveRequest;
use App\Http\Requests\UpdateLeaveRequest;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class LeaveController extends Controller
{
    public function create(CreateLeaveRequest $request){

        $leave = Leave::create($request->all());
       

        if($leave){
            return ResponseFormatter::success($leave, 'Leave Created');
        }

        return ResponseFormatter::error(null, 'Leave Failed to Create');
}

    public function fetch(Request $request){
        $id = $request->input('id');
        $user_id = $request->input('user_id');
        $limit = $request->input('limit', 10);

        // get multiple data
        $leaveQuery = Leave::query()->with(['user', 'approver', 'handover']);

        // get single data

       if($request->has('id')){
            $id = Hashids::decode($id);
            $leave = $leaveQuery->where('id', $id)->get();

            if($leave->isNotEmpty()){
                return ResponseFormatter::success($leave, 'Leave Found');
            }
            return ResponseFormatter::error('Leave Not Found',404);
        }


        if($request->has('user_id')){
            $user_id = Hashids::decode($user_id);
            $leave = $leaveQuery->where('user_id', $user_id)->get();

            if($leave->isNotEmpty()){
                return ResponseFormatter::success($leave, 'Leave Found');
            }
            return ResponseFormatter::error('Leave Not Found',404);
        }

        $leave = $leaveQuery->paginate($limit);

        if($leave->isNotEmpty()){
            return ResponseFormatter::success($leave, 'Leave Found');
        };
        
        return ResponseFormatter::error('Leave Not Found', 404);

        
    }

    public function update(UpdateLeaveRequest $request, $id){
       
        $id = Hashids::decode($id)[0];
        $leave = Leave::find($id);

        if($leave){
            $leave->update($request->all()
            );

            return ResponseFormatter::success($leave, 'Leave Updated');
        }

        return ResponseFormatter::error('Leave Failed to Update', 404);
    }

    public function delete($id){
        $id = Hashids::decode($id)[0];
        $leave = Leave::find($id);

        if($leave){
            $leave->delete();

            return ResponseFormatter::success($leave, 'Leave Deleted');
        }

        return ResponseFormatter::error(null, 'Leave Failed to Delete');
    }
}
