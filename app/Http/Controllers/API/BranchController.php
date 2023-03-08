<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
Use App\Models\Branch;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\CreateBranchRequest;
use App\Http\Requests\UpdateBranchRequest;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
class BranchController extends Controller
{
    public function create(CreateBranchRequest $request){

        $branch = Branch::create($request->all());
       

        if($branch){
            return ResponseFormatter::success($branch, 'Branch Created');
        }

        return ResponseFormatter::error(null, 'Branch Failed to Create');
}

    public function fetch(Request $request){
        $id = $request->input('id');
        $limit = $request->input('limit', 10);

        // get multiple data
        $branchQuery = Branch::query();

        // get single data

        if($request->has('id')){
            $id = Hashids::decode($id); 
            $branch= $branchQuery->where('id', $id)->get();

            if($branch->isNotEmpty()){
                return ResponseFormatter::success($branch, 'Branch Found');
            }
            return ResponseFormatter::error('Branch Not Found', 404);
        }
        $branch = $branchQuery->paginate($limit);
        if($branch->isNotEmpty()){
            return ResponseFormatter::success($branch, 'Branch Found');
        }
        return ResponseFormatter::error('Branch Not Found', 404);

        
    }

    public function update(UpdateBranchRequest $request, $id){

       
        $id = Hashids::decode($id)[0];
        $branch = Branch::find($id);

        if($branch){
            $branch->update($request->all()
            );

            return ResponseFormatter::success($branch, 'Branch Updated');
        }

        return ResponseFormatter::error(null, 'Branch Failed to Update');
    }

    public function delete($id){
        $id = Hashids::decode($id)[0];
        $branch = Branch::find($id);

        if($branch){
            $branch->delete();

            return ResponseFormatter::success($branch, 'Branch Deleted');
        }

        return ResponseFormatter::error('Branch Failed to Delete',404);
    }
}
