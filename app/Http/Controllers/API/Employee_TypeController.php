<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee_Type;
use App\Helpers\ResponseFormatter;
use Vinkla\Hashids\Facades\Hashids;

class Employee_TypeController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255'],
        ]);

        $employee_type = Employee_Type::create([
            'name' => $request->name,
            'code' => $request->code,
        ]);

        if ($employee_type) {
            return ResponseFormatter::success($employee_type, 'Employee Type Created');
        }

        return ResponseFormatter::error(null, 'Employee Type Failed to Create');
    }

    public function fetch(Request $request)
    {
        $id = $request->input('id');
        $employee_type = Employee_Type::query()->get();

        if ($request->has('id')) {
            $id = Hashids::decode($id);
            $employee_type = Employee_Type::find($id);

            if ($employee_type->isNotEmpty()) {
                return ResponseFormatter::success($employee_type, 'Employee Type Found');
            }
            return ResponseFormatter::error('Employee Type Not Found', 404);
        }

        return ResponseFormatter::success($employee_type, 'Employee Type Fetched');



        return ResponseFormatter::error(null, 'Employee Type Failed to Fetch');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:255'],

        ]);
        $id = Hashids::decode($id)[0];
        $employee_type = Employee_Type::find($id);

        if ($employee_type) {

            $employee_type->update($request->all());

            return ResponseFormatter::success($employee_type, 'Employee Type Updated');
        }

        return ResponseFormatter::error('Employee Type Failed to Update', 404);
    }

    public function delete($id)
    {
        $id = Hashids::decode($id)[0];
        $employee_type = Employee_Type::find($id);

        if ($employee_type) {
            $employee_type->delete();

            return ResponseFormatter::success($employee_type, 'Employee Type Deleted');
        }

        return ResponseFormatter::error(null, 'Employee Type Failed to Delete');
    }
}
