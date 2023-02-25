<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
Use App\Models\Salary;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\CreateSalaryRequest;
use App\Http\Requests\UpdateSalaryRequest;
use Illuminate\Http\Request;


class SalaryController extends Controller
{
    public function create(CreateSalaryRequest $request){

        $salary = Salary::create([
            'user_id' => $request->user_id,
            'bank_account_number' => $request->bank_account_number,
            'bank_name' => $request->bank_name,
            'bank_of_issue' => $request->bank_of_issue,
            'npwp_number' => $request->npwp_number,
            'signed_date' => $request->signed_date,
            'sallary_type' => $request->sallary_type,
            'sallary_form' => $request->sallary_form,
            'amout_sallary' => $request->amout_sallary,
            'amout_allowance' => $request->amout_allowance,
            'allowance_type' => $request->allowance_type,
            'note' => $request->note,
        ]);
       

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

        if($id){
            $salary = $salaryQuery->find($id);

            if($salary){
                return ResponseFormatter::success($salary, 'Salary Found');
            }
            return ResponseFormatter::error(null, 'Salary Not Found');
        }


        if($user_id){
           $salary = $salaryQuery->where('user_id', $user_id)->first();

            if($salary){
                return ResponseFormatter::success($salary, 'Salary Found');
            }
            return ResponseFormatter::error(null, 'Salary Not Found');
        };

        return ResponseFormatter::success($salaryQuery->paginate($limit), 'Salary Found');

        
    }

    public function update(UpdateSalaryRequest $request, $id){
       

        $salary = Salary::find($id);

        if($salary){
            $salary->update([
                'user_id' => $request->user_id,
                'bank_account_number' => $request->bank_account_number,
                'bank_name' => $request->bank_name,
                'bank_of_issue' => $request->bank_of_issue,
                'npwp_number' => $request->npwp_number,
                'signed_date' => $request->signed_date,
                'sallary_type' => $request->sallary_type,
                'sallary_form' => $request->sallary_form,
                'amout_sallary' => $request->amout_sallary,
                'amout_allowance' => $request->amout_allowance,
                'allowance_type' => $request->allowance_type,
                'note' => $request->note,
            ]
            );

            return ResponseFormatter::success($salary, 'Salary Updated');
        }

        return ResponseFormatter::error(null, 'Salary Failed to Update');
    }

    public function delete($id){
        $salary = Salary::find($id);

        if($salary){
            $salary->delete();

            return ResponseFormatter::success($salary, 'Salary Deleted');
        }

        return ResponseFormatter::error(null, 'Salary Failed to Delete');
    }
}
