<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
Use App\Models\Leave;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\CreateLeaveRequest;
use App\Http\Requests\UpdateLeaveRequest;
use Illuminate\Http\Request;


class LeaveController extends Controller
{
    public function create(CreateLeaveRequest $request){

        $leave = Leave::create([
            'user_id' => $request->user_id,
            'approver_id' => $request->approver_id,
            'handover_id' => $request->handover_id,
            'subject' => $request->subject,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'number_of_days' => $request->number_of_days,
            'leave_type' => $request->leave_type,
            'status' => $request->status,
        ]);
       

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

        if($id){
            $leave = $leaveQuery->find($id);

            if($leave){
                return ResponseFormatter::success($leave, 'Leave Found');
            }
            return ResponseFormatter::error(null, 'Leave Not Found');
        }


        if($user_id){
           $leave = $leaveQuery->where('user_id', $user_id)->get();

            if($leave){
                return ResponseFormatter::success($leave, 'Leave Found');
            }
            return ResponseFormatter::error(null, 'Leave Not Found');
        };

        return ResponseFormatter::success($leaveQuery->paginate($limit), 'Leave Found');

        
    }

    public function update(UpdateLeaveRequest $request, $id){
       

        $leave = Leave::find($id);

        if($leave){
            $leave->update([
            'user_id' => $request->user_id,
            'approver_id' => $request->approver_id,
            'handover_id' => $request->handover_id,
            'subject' => $request->subject,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'number_of_days' => $request->number_of_days,
            'leave_type' => $request->leave_type,
            'status' => $request->status,
            ]
            );

            return ResponseFormatter::success($leave, 'Leave Updated');
        }

        return ResponseFormatter::error(null, 'Leave Failed to Update');
    }

    public function delete($id){
        $leave = Leave::find($id);

        if($leave){
            $leave->delete();

            return ResponseFormatter::success($leave, 'Leave Deleted');
        }

        return ResponseFormatter::error(null, 'Leave Failed to Delete');
    }
}
