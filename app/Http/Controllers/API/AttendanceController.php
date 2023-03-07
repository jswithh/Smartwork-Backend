<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateAttendanceRequest;
use Vinkla\Hashids\Facades\Hashids;

class AttendanceController extends Controller
{
    public function fetchByUser(){

        // smartwork.id/api/attendance/fetch
        $user = Auth::user();
        $attendance = Attendance::where('user_id', $user->id)->with('user')->get();
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
        $department_id = $request->input('department_id');
        $limit = $request->input('limit', 10);

        $attendance = Attendance::query();

        if($id){
            $id = Hashids::decode($id);
            $attendance->where('id', $id);
        }

        if($user_id){
            $user_id = Hashids::decode($user_id);
            $attendance->where('user_id', $user_id);
        }

        if($month){
            $attendance->whereMonth('created_at', $month);
        }

        if($year){
            $attendance->whereYear('created_at', $year);
        }

        if($department_id){
            $department_id = Hashids::decode($department_id);
            $attendance->whereHas('user', function($user) use ($department_id){
                $user->where('department_id', $department_id);
            });
        }
        
        return ResponseFormatter::success(
            $attendance->paginate($limit),
            'Data Absensi berhasil diambil'
        );
    }

     public function update(UpdateAttendanceRequest $request, $id){
       
        $id = Hashids::decode($id)[0];
        $attendance = Attendance::find($id);

        if($attendance){
            $attendance->update($request->all()
            );

            return ResponseFormatter::success($attendance, 'Attendance Updated');
        }

        return ResponseFormatter::error(null, 'Attendance Failed to Update');
    }

    public function delete($id){
        $id = Hashids::decode($id)[0];
        $attendance = Attendance::find($id);

        if($attendance){
            $attendance->delete();

            return ResponseFormatter::success($attendance, 'Attendance Deleted');
        }

        return ResponseFormatter::error(null, 'Attendance Failed to Delete');
    }
    
}
