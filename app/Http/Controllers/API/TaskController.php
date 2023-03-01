<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
Use App\Models\Task;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\Request;


class TaskController extends Controller
{
    public function create(CreateTaskRequest $request){

        $task = Task::create([
                'name' => $request->name,
                'description' => $request->description,
                'priority' => $request->priority,
                'date_added' => $request->date_added,
                'start_date' => $request->start_date,
                'due_date' => $request->due_date,
                'date_completed' => $request->date_completed,
                'status' => $request->status,
                'created_by' => $request->created_by,
                'assigned_to' => $request->assigned_to,
        ]);
       

        if($task){
            return ResponseFormatter::success($task, 'Task Created');
        }

        return ResponseFormatter::error(null, 'Task Failed to Create');
}

    public function fetch(Request $request){
        $id = $request->input('id');
        $user_id = $request->input('user_id');
        $limit = $request->input('limit', 10);

        // get multiple data
        $taskQuery = Task::query();

        // get single data

        if($id){
            $task = $taskQuery->find($id);

            if($task){
                return ResponseFormatter::success($task, 'Task Found');
            }
            return ResponseFormatter::error(null, 'Task Not Found');
        }


        if($user_id){
           $task = $taskQuery->where('created_by', $user_id)->get();

            if($task){
                return ResponseFormatter::success($task, 'Task Found');
            }
            return ResponseFormatter::error(null, 'Task Not Found');
        };

        return ResponseFormatter::success($taskQuery->paginate($limit), 'Task Found');

        
    }

    public function update(UpdateTaskRequest $request, $id){
       

        $task = Task::find($id);

        if($task){
            $task->update([
             'user_id' => $request->user_id,
            'company_name' => $request->company_name,
            'location' => $request->location,
            'job_title' => $request->job_title,
            'employee_type_id' => $request->employee_type_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'job_description' => $request->job_description,
            ]
            );

            return ResponseFormatter::success($task, 'Task Updated');
        }

        return ResponseFormatter::error(null, 'Task Failed to Update');
    }

    public function delete($id){
        $task = Task::find($id);

        if($task){
            $task->delete();

            return ResponseFormatter::success($task, 'Task Deleted');
        }

        return ResponseFormatter::error(null, 'Task Failed to Delete');
    }
}
