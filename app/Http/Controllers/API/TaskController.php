<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
Use App\Models\Task;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class TaskController extends Controller
{
    public function create(CreateTaskRequest $request){

        $task = Task::create($request->all());
       

        if($task){
            return ResponseFormatter::success($task, 'Task Created');
        }

        return ResponseFormatter::error(null, 'Task Failed to Create');
}

    public function fetch(Request $request){
        $id = $request->input('id');
        $created_by = $request->input('created_by');
        $limit = $request->input('limit', 10);

        // get multiple data
        $taskQuery = Task::query();

        // get single data

        if($request->has('id')){
            $id = Hashids::decode($id);
            $task = $taskQuery->where('id', $id)->get();

            if($task->isNotEmpty()){
                return ResponseFormatter::success($task, 'Task Found');
            }
            return ResponseFormatter::error('Task Not Found',404);
        }


        if($request->has('created_by')){
            $created_by = Hashids::decode($created_by);
            $task = $taskQuery->where('created_by', $created_by)->get();

            if($task->isNotEmpty()){
                return ResponseFormatter::success($task , 'Task Found');
            }
            return ResponseFormatter::error('Task Not Found',404);
        }

        return ResponseFormatter::success($taskQuery->paginate($limit), 'Task Found');

        
    }

    public function update(UpdateTaskRequest $request, $id){
       
        $id = Hashids::decode($id)[0];
        $task = Task::find($id);

        if($task){
            $task->update($request->all());

            return ResponseFormatter::success($task, 'Task Updated');
        }

        return ResponseFormatter::error(null, 'Task Failed to Update');
    }

    public function delete($id){
        $id = Hashids::decode($id)[0];
        $task = Task::find($id);

        if($task){
            $task->delete();

            return ResponseFormatter::success($task, 'Task Deleted');
        }

        return ResponseFormatter::error(null, 'Task Failed to Delete');
    }
}
