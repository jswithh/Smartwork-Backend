<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
Use App\Models\Project;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class ProjectController extends Controller
{
    public function create(CreateProjectRequest $request){

        $project = Project::create($request->all());
       

        if($project){
            return ResponseFormatter::success($project, 'Project Created');
        }

        return ResponseFormatter::error(null, 'Project Failed to Create');
}

    public function fetch(Request $request){
        $id = $request->input('id');
        $created_by = $request->input('created_by');
        $limit = $request->input('limit', 10);

        // get multiple data
        $projectQuery = Project::query()->with('tasks');

        // get single data
        if($request->has('id')){
            $id = Hashids::decode($id);
            $project = $projectQuery->where('id', $id)->get();

            if($project->isNotEmpty()){
                return ResponseFormatter::success($project, 'Project Found');
            }
            return ResponseFormatter::error('Project Not Found',404);
        }


        if($request->has('created_by')){
            $created_by = Hashids::decode($created_by);
            $project = $projectQuery->where('created_by', $created_by)->get();

            if($project->isNotEmpty()){
                return ResponseFormatter::success($project, 'Project Found');
            }
            return ResponseFormatter::error('Project Not Found',404);
        }

        $project = $projectQuery->paginate($limit); 
        if($project->isNotEmpty()){
            return ResponseFormatter::success($project, 'Project Found');
        }
        return ResponseFormatter::error('Project Not Found',404);
        
    }

    public function update(UpdateProjectRequest $request, $id){
       
        $id = Hashids::decode($id)[0];
        $project = Project::find($id);

        if($project){
            $project->update($request->all()
            );

            return ResponseFormatter::success($project, 'Project Updated');
        }

        return ResponseFormatter::error('Project Failed to Update',404);
    }

    public function delete($id){
        $id = Hashids::decode($id)[0];
        $project = Project::find($id);

        if($project){
            $project->delete();

            return ResponseFormatter::success($project, 'Project Deleted');
        }

        return ResponseFormatter::error('Project Failed to Delete',404);
    }
}
