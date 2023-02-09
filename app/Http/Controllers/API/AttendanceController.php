<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAttendanceRequest;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function fetch(Request $request){
        $id = $request->input('id');
        $name = $request->input('name');
        $limit = $request->input('limit', 10);

        // smartwork.id/api/Attendance?id=1
        if ($id) {
            $Attendance = Attendance::whereHas('company', function($company){
                $company->where('company_id', Auth::id());
            })->with(['company'])->find($id);

            if ($Attendance){
                return ResponseFormatter::success(
                    $Attendance,
                    'Data Attendance berhasil diambil'
                );
            }
           
                return ResponseFormatter::error(
                    'Data Attendance tidak ada',
                    404
                );
        }

        // smartwork.id/api/Attendance
        $Attendance = Attendance::wherHas('company', function($company){
            $company->where('company_id', Auth::id());
        })->with(['company'])->get();

        return ResponseFormatter::success(
            $Attendance,
            'Data list Attendance berhasil diambil'
        );
    }

    public function create(CreateAttendanceRequest $request){
        try {
            $Attendance = Attendance::create([
                'company_id' => $request->company_id,
                'employee_id' => $request->employee_id,
                'clock_in' => $request->clock_in,
                'clock_out' => $request->clock_out,
                'working_from' => $request->working_from,
                'late' => $request->late,
                'clock_out_address' => $request->clock_out_address,
                'working_hours' => $request->working_hours,
                'break_in' => $request->break_in,
                'break_out' => $request->break_out,
                'break_hours' => $request->break_hours,
                'totally' => $request->totally,
                'overtime' => $request->overtime,
            ]);

            return ResponseFormatter::success(
                $Attendance,
                'Data Attendance berhasil ditambahkan'
            );
        } catch (\Exception $error) {
            return ResponseFormatter::error(
                [
                    'message' => 'Something went wrong',
                    'error' => $error
                ],
                'Data Attendance gagal ditambahkan',
                500
            );
        }
    }
    
}
