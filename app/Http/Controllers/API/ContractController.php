<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
Use App\Models\Contract;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\CreateContractRequest;
use App\Http\Requests\UpdateContractRequest;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class ContractController extends Controller
{
    public function create(CreateContractRequest $request){

        $contract = Contract::create($request->all());
       

        if($contract){
            return ResponseFormatter::success($contract, 'Contract Created');
        }

        return ResponseFormatter::error(null, 'Contract Failed to Create');
}

    public function fetch(Request $request){
        $id = $request->input('id');
        $user_id = $request->input('user_id');
        $limit = $request->input('limit', 10);

        // get multiple data
        $contractQuery = Contract::query()->with('employee_type');

        // get single data

          if($request->has('id')){
            $id = Hashids::decode($id);
            if($id !== null){
               $contract= $contractQuery->where('id', $id)->get();
            }

            if($contract->isNotEmpty()){
                return ResponseFormatter::success($contract, 'Contract Found');
            }
            return ResponseFormatter::error('Contract Not Found', 404);
        }


        if($user_id){
            $user_id = Hashids::decode($user_id);
           $contract = $contractQuery->where('user_id', $user_id)->get();

            if($contract->isNotEmpty()){
                return ResponseFormatter::success($contract, 'Contract Found');
            }
            return ResponseFormatter::error('Contract Not Found',404);
        };

         return ResponseFormatter::success(
            $contractQuery->paginate($limit),
            'Departments found'
        );

        
    }

    public function update(UpdateContractRequest $request, $id){
       
        $id = Hashids::decode($id)[0];
        $contract = Contract::find($id);

        if($contract){
            $contract->update($request->all()
            );

            return ResponseFormatter::success($contract, 'Contract Updated');
        }

        return ResponseFormatter::error(null, 'Contract Failed to Update');
    }

    public function delete($id){
        $id = Hashids::decode($id)[0];
        $contract = Contract::find($id);

        if($contract){
            $contract->delete();

            return ResponseFormatter::success($contract, 'Contract Deleted');
        }

        return ResponseFormatter::error(null, 'Contract Failed to Delete');
    }
}
