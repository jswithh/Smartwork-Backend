<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
Use App\Models\Salary;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\CreateSalaryRequest;
use App\Http\Requests\UpdateSalaryRequest;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class SalaryController extends Controller
{
    public function create(CreateSalaryRequest $request){

        $salary = Salary::create($request->all());
       

        if($salary){
            return ResponseFormatter::success($salary, 'Salary Created');
        }

        return ResponseFormatter::error(null, 'Salary Failed to Create');
}

    public function fetch(Request $request){
        $id = $request->input('id');
        $user_id = $request->input('user_id');
        $limit = $request->input('limit', 10);

        // get multiple data
        $salaryQuery = Salary::query();

        // get single data

       if($request->has('id')){
            $id = Hashids::decode($id);
            $salary = $salaryQuery->where('id', $id)->get();

            if($salary->isNotEmpty()){
                return ResponseFormatter::success($salary, 'Salary Found');
            }
            return ResponseFormatter::error('Salary Not Found',404);
        }

        if($request->has('user_id')){
            $user_id = Hashids::decode($user_id);
            $salary = $salaryQuery->where('user_id', $user_id)->get();

            if($salary ){
                return ResponseFormatter::success($salary , 'Salary Found');
            }
            return ResponseFormatter::error('Salary Not Found',404);
        }

        $salary = $salaryQuery->paginate($limit);
        if($salary){
            return ResponseFormatter::success($salary, 'Salary Found');
        }
        return ResponseFormatter::error('Salary Not Found',404);
        
    }

    public function update(UpdateSalaryRequest $request, $id){
       
        $id = Hashids::decode($id)[0];
        $salary = Salary::find($id);

        if($salary){
            $salary->update($request->all());

            return ResponseFormatter::success($salary, 'Salary Updated');
        }

        return ResponseFormatter::error(null, 'Salary Failed to Update');
    }

    public function delete($id){
        $id = Hashids::decode($id)[0];
        $salary = Salary::find($id);

        if($salary){
            $salary->delete();

            return ResponseFormatter::success($salary, 'Salary Deleted');
        }

        return ResponseFormatter::error(null, 'Salary Failed to Delete');
    }
}
