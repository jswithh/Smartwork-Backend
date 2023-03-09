<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use Vinkla\Hashids\Facades\Hashids;

class DepartmentController extends Controller
{
    public function fetch(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $assigned = $request->input('assigned');
        $limit = $request->input('limit', 10);
        $with_responsibilities = $request->input('with_responsibilities', false);

        $departmentQuery = Department::query()->with('sub_departments');

        // Get single data
        if($request->has('id')){
            $id = Hashids::decode($id);
            $encode = Hashids::encode(2);
            if($id !== null){
               $department= $departmentQuery->where('id', $id)->get();
            }

            if($department->isNotEmpty()){
                return ResponseFormatter::success($department, $encode);
            }
            return ResponseFormatter::error('Career experience Not Found', 404);
        }

        // Get multiple data
        $departments = $departmentQuery;

        if ($name) {
            $departments->where('name', 'like', '%' . $name . '%');
        }

        if ($with_responsibilities) {
            $departments->with('responsibilities');
        }
        
        if($assigned){
            $departments->withCount('users');
        }

        return ResponseFormatter::success(
            $departments->paginate($limit),
            'Departments found'
        );
    }

    public function create(CreateDepartmentRequest $request)
    {
        try {
            // Create department
            $department = Department::create($request->all());

            if (!$department) {
                throw new Exception('Department not created');
            }

            return ResponseFormatter::success($department, 'Department created');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }

    public function update(UpdateDepartmentRequest $request, $id)
    {

        try {
            // Get department
            $id = Hashids::decode($id)[0];
            $department = Department::find($id);

            // Check if department exists
            if (!$department) {
                throw new Exception('Department not found');
            }

            // Update department
            $department->update($request->all());

            return ResponseFormatter::success($department, 'Department updated');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }

    public function delete($id)
    {
        try {
            // Get department
            $id = Hashids::decode($id)[0];
            $department = Department::find($id);

            // TODO: Check if department is owned by user

            // Check if department exists
            if (!$department) {
                throw new Exception('Department not found');
            }

            // Delete department
            $department->delete();

            return ResponseFormatter::success('Department deleted');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }
}