<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
Use App\Models\Insurance;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\CreateInsuranceRequest;
use App\Http\Requests\UpdateInsuranceRequest;
use Illuminate\Http\Request;


class InsuranceController extends Controller
{
    public function create(CreateInsuranceRequest $request){

        $insurance = Insurance::create([
            'user_id' => $request->user_id,
            'insurance_type' => $request->insurance_type,
            'insurance_number' => $request->insurance_number,
            'secondary_insurance_type' => $request->secondary_insurance_type,
            'secondary_insurance_number' => $request->secondary_insurance_number,
        ]);
       

        if($insurance){
            return ResponseFormatter::success($insurance, 'Insurance Created');
        }

        return ResponseFormatter::error(null, 'Insurance Failed to Create');
}

    public function fetch(Request $request){
        $id = $request->input('id');
        $user_id = $request->input('user_id');
        $limit = $request->input('limit', 10);

        // get multiple data
        $insuranceQuery = Insurance::query()->with('employee_type');

        // get single data

        if($id){
            $insurance = $insuranceQuery->find($id)->with('employee_type');

            if($insurance){
                return ResponseFormatter::success($insurance, 'Insurance Found');
            }
            return ResponseFormatter::error(null, 'Insurance Not Found');
        }


        if($user_id){
           $insurance = $insuranceQuery->where('user_id', $user_id)->get()->with('employee_type');

            if($insurance){
                return ResponseFormatter::success($insurance, 'Insurance Found');
            }
            return ResponseFormatter::error(null, 'Insurance Not Found');
        };

        if($insuranceQuery === null){
            return ResponseFormatter::error(null, 'Insurance Not Found');
        }

        return ResponseFormatter::success($insuranceQuery->paginate($limit), 'Insurance Found');

        
    }

    public function update(UpdateInsuranceRequest $request, $id){
       

        $insurance = Insurance::find($id);

        if($insurance){
            $insurance->update([
                'user_id' => $request->user_id,
                'insurance_type' => $request->insurance_type,
                'insurance_number' => $request->insurance_number,
                'secondary_insurance_type' => $request->secondary_insurance_type,
                'secondary_insurance_number' => $request->secondary_insurance_number,
            ]
            );

            return ResponseFormatter::success($insurance, 'Insurance Updated');
        }

        return ResponseFormatter::error(null, 'Insurance Failed to Update');
    }

    public function delete($id){
        $insurance = Insurance::find($id);

        if($insurance){
            $insurance->delete();

            return ResponseFormatter::success($insurance, 'Insurance Deleted');
        }

        return ResponseFormatter::error(null, 'Insurance Failed to Delete');
    }
}
