<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateAttendanceRequest;

class AttendanceController extends Controller
{
    public function fetchByUser(){

        // smartwork.id/api/attendance/fetch
        $user = Auth::user();
        $attendance = Attendance::where('user_id', $user->id)->get();
        return ResponseFormatter::success(
            $attendance,
            'Data Absensi berhasil diambil'
        );
    }
    public function fetchAll(Request $request){
        // smartwork.id/api/attendance/fetch-all
        $id = $request->input('id');
        $user_id = $request->input('user_id');
        $month = $request->input('month');
        $year = $request->input('year');
        $role_id = $request->input('role_id');
        $limit = $request->input('limit', 10);

        $attendance = Attendance::query();

        if($id){
            $attendance->where('id', $id);
        }

        if($user_id){
            $attendance->where('user_id', $user_id);
        }

        if($month){
            $attendance->whereMonth('created_at', $month);
        }

        if($year){
            $attendance->whereYear('created_at', $year);
        }

        if($role_id){
            $attendance->whereHas('user', function($user) use ($role_id){
                $user->where('role_id', $role_id);
            });
        }
        
        return ResponseFormatter::success(
            $attendance->paginate($limit),
            'Data Absensi berhasil diambil'
        );
    }

     public function update(UpdateAttendanceRequest $request, $id){
       

        $attendance = Attendance::find($id);

        if($attendance){
            $attendance->update([
            'user_id' => $request->user_id,
            'clock_in_time' => $request->clock_in_time,
            'clock_out_time' => $request->clock_out_time,
            'working_from' => $request->working_from,
            'late' => $request->late,
            'clock_out_addres' => $request->clock_out_addres,
            'work_hours' => $request->working_hours,
            'break_in' => $request->break_in,
            'break_out' => $request->break_out,
            'break_hours' => $request->break_hours,
            'Totally' => $request->Totally,
            'Overtime' => $request->Overtime,
            ]
            );

            return ResponseFormatter::success($attendance, 'Attendance Updated');
        }

        return ResponseFormatter::error(null, 'Attendance Failed to Update');
    }

    public function delete($id){
        $attendance = Attendance::find($id);

        if($attendance){
            $attendance->delete();

            return ResponseFormatter::success($attendance, 'Attendance Deleted');
        }

        return ResponseFormatter::error(null, 'Attendance Failed to Delete');
    }
    
}
