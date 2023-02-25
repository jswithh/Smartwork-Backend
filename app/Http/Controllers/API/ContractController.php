<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
Use App\Models\Contract;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\CreateContractRequest;
use App\Http\Requests\UpdateContractRequest;
use Illuminate\Http\Request;


class ContractController extends Controller
{
    public function create(CreateContractRequest $request){

        $contract = Contract::create([
            'user_id' => $request->user_id,
            'employee_type_id' => $request->employee_type_id,
            'contract_status' => $request->contract_status,
            'contract_start_date' => $request->contract_start_date,
            'contract_end_date' => $request->contract_end_date,
        ]);
       

        if($contract){
            return ResponseFormatter::success($contract, 'Career experience Created');
        }

        return ResponseFormatter::error(null, 'Career experience Failed to Create');
}

    public function fetch(Request $request){
        $id = $request->input('id');
        $user_id = $request->input('user_id');
        $limit = $request->input('limit', 10);

        // get multiple data
        $contractQuery = Contract::query()->with('employee_type');

        // get single data

        if($id){
            $contract = $contractQuery->find($id)->with('employee_type');

            if($contract){
                return ResponseFormatter::success($contract, 'Career experience Found');
            }
            return ResponseFormatter::error(null, 'Career experience Not Found');
        }


        if($user_id){
           $contract = $contractQuery->where('user_id', $user_id)->get()->with('employee_type');

            if($contract){
                return ResponseFormatter::success($contract, 'Career experience Found');
            }
            return ResponseFormatter::error(null, 'Career experience Not Found');
        };

        return ResponseFormatter::success($contractQuery->paginate($limit), 'Career experience Found');

        
    }

    public function update(UpdateContractRequest $request, $id){
       

        $contract = Contract::find($id);

        if($contract){
            $contract->update([
            'user_id' => $request->user_id,
            'employee_type_id' => $request->employee_type_id,
            'contract_status' => $request->contract_status,
            'contract_start_date' => $request->contract_start_date,
            'contract_end_date' => $request->contract_end_date,
            ]
            );

            return ResponseFormatter::success($contract, 'Career experience Updated');
        }

        return ResponseFormatter::error(null, 'Career experience Failed to Update');
    }

    public function delete($id){
        $contract = Contract::find($id);

        if($contract){
            $contract->delete();

            return ResponseFormatter::success($contract, 'Career experience Deleted');
        }

        return ResponseFormatter::error(null, 'Career experience Failed to Delete');
    }
}
