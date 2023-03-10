<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
Use App\Models\Reminder_type;
use App\Helpers\ResponseFormatter;

use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
class Reminder_typeController extends Controller
{
    public function create(Request $request){

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $reminder_type = Reminder_type::create($request->all());
       

        if($reminder_type){
            return ResponseFormatter::success($reminder_type, 'Reminder type Created');
        }

        return ResponseFormatter::error(null, 'Reminder type Failed to Create');
}

    public function fetch(Request $request){
        $id = $request->input('id');
        $limit = $request->input('limit', 10);

        // get multiple data
        $reminder_typeQuery = Reminder_type::query();

        // get single data

        if($request->has('id')){
            $id = Hashids::decode($id); 
            $reminder_type= $reminder_typeQuery->where('id', $id)->get();

            if($reminder_type->isNotEmpty()){
                return ResponseFormatter::success($reminder_type, 'Reminder type Found');
            }
            return ResponseFormatter::error('Reminder type Not Found', 404);
        }
        $reminder_type = $reminder_typeQuery->paginate($limit);
        if($reminder_type->isNotEmpty()){
            return ResponseFormatter::success($reminder_type, 'Reminder type Found');
        }
        return ResponseFormatter::error('Reminder type Not Found', 404);

        
    }

    public function update(Request $request, $id){

        $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
        ]);
        $id = Hashids::decode($id)[0];
        $reminder_type = Reminder_type::find($id);

        if($reminder_type){
            $reminder_type->update($request->all()
            );

            return ResponseFormatter::success($reminder_type, 'Reminder type Updated');
        }

        return ResponseFormatter::error(null, 'Reminder type Failed to Update');
    }

    public function delete($id){
        $id = Hashids::decode($id)[0];
        $reminder_type = Reminder_type::find($id);

        if($reminder_type){
            $reminder_type->delete();

            return ResponseFormatter::success($reminder_type, 'Reminder type Deleted');
        }

        return ResponseFormatter::error('Reminder type Failed to Delete',404);
    }
}
