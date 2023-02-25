<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use App\Models\Employee_Type;
use App\Helpers\ResponseFormatter;


class Employee_TypeController extends Controller
{
    public function create(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:50'],
        ]);

        $employee_type = Employee_Type::create([
            'name' => $request->name,
        ]);

        if($employee_type){
            return ResponseFormatter::success($employee_type, 'Job Level Created');
        }

        return ResponseFormatter::error(null, 'Job Level Failed to Create');
}

    public function fetch(){
        $employee_type = Employee_Type::all();

        if($employee_type){
            return ResponseFormatter::success($employee_type, 'Job Level Fetched');
        }

        return ResponseFormatter::error(null, 'Job Level Failed to Fetch');
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => ['required', 'string', 'max:50'],
        ]);

        $employee_type = Employee_Type::find($id);

        if($employee_type){
            $employee_type->name = $request->name;
            $employee_type->save();

            return ResponseFormatter::success($employee_type, 'Job Level Updated');
        }

        return ResponseFormatter::error(null, 'Job Level Failed to Update');
    }

    public function delete($id){
        $employee_type = Employee_Type::find($id);

        if($employee_type){
            $employee_type->delete();

            return ResponseFormatter::success($employee_type, 'Job Level Deleted');
        }

        return ResponseFormatter::error(null, 'Job Level Failed to Delete');
    }
}
