<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
Use App\Models\Project;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Http\Request;


class ProjectController extends Controller
{
    public function create(CreateProjectRequest $request){

        $project = Project::create([
                'created_by' => $request->created_by,
                'name' => $request->name,
                'description' => $request->description,
                'date_added' => $request->date_added,
                'start_date' => $request->start_date,
                'due_date' => $request->due_date,
                'status' => $request->status,
                'priority' => $request->priority,
        ]);
       

        if($project){
            return ResponseFormatter::success($project, 'Project Created');
        }

        return ResponseFormatter::error(null, 'Project Failed to Create');
}

    public function fetch(Request $request){
        $id = $request->input('id');
        $user_id = $request->input('user_id');
        $limit = $request->input('limit', 10);

        // get multiple data
        $projectQuery = Project::query();

        // get single data

        if($id){
            $project = $projectQuery->find($id);

            if($project){
                return ResponseFormatter::success($project, 'Project Found');
            }
            return ResponseFormatter::error(null, 'Project Not Found');
        }


        if($user_id){
           $project = $projectQuery->where('created_by', $user_id)->get();

            if($project){
                return ResponseFormatter::success($project, 'Project Found');
            }
            return ResponseFormatter::error(null, 'Project Not Found');
        };

        return ResponseFormatter::success($projectQuery->paginate($limit), 'Project Found');

        
    }

    public function update(UpdateProjectRequest $request, $id){
       

        $project = Project::find($id);

        if($project){
            $project->update([
                'created_by' => $request->created_by,
                'name' => $request->name,
                'description' => $request->description,
                'date_added' => $request->date_added,
                'start_date' => $request->start_date,
                'due_date' => $request->due_date,
                'status' => $request->status,
                'priority' => $request->priority,
            ]
            );

            return ResponseFormatter::success($project, 'Project Updated');
        }

        return ResponseFormatter::error(null, 'Project Failed to Update');
    }

    public function delete($id){
        $project = Project::find($id);

        if($project){
            $project->delete();

            return ResponseFormatter::success($project, 'Project Deleted');
        }

        return ResponseFormatter::error(null, 'Project Failed to Delete');
    }
}
