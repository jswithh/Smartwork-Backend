<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\Team;
use Exception;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function fetch(Request $request){
        $id = $request->input('id');
        $name = $request->input('name');
        $assigned = $request->input('assigned');
        $limit = $request->input('limit', 10);

        $teamQuery = Team::query();

        // smartwork.id/api/team?id=1
        if ($id) {
            $team = $teamQuery->find($id);

            if ($team){
                return ResponseFormatter::success(
                    $team,
                    'Data team berhasil diambil'
                );}
           
                return ResponseFormatter::error(
                    'Data team tidak ada',
                    404
                );
        }
        // smartwork.id/api/team
        $team = $teamQuery;

        // smartwork.id/api/team?name=hracademy
        if ($name){
            $team->where('name', 'like', '%' . $name . '%');
        }

        if($assigned){
            $team->withCount('employees');
        }

        return ResponseFormatter::success(
            $team->paginate($limit),
            'Data list team berhasil diambil'
        );
    }
    public function create(CreateTeamRequest $request){
        try {
            if($request->file('icon')){
                  $path = url('/').'/storage/team_icon/' . $request->file('icon')->hashName();
                 $request->file('icon')->store('public/team_icon');
            }
            $team = Team::create([
                'name' => $request->name,
                'icon' => $path,
            ]);

        

            return ResponseFormatter::success(
                $team,
                'Data team berhasil ditambahkan'
            );

            
        } catch (Exception $error) {
            return ResponseFormatter::error(
                [
                    'message' => 'Something went wrong',
                    'error' => $error
                ],
                'Data team gagal ditambahkan',
                500
            );
        }
    }

    public function update(UpdateTeamRequest $request){
        try {
            $team = Team::find($request->id);

            // check team is owned by user 
            if($team){
                $team->name = $request->name;
                $team->icon = $request->icon;
                $team->save();

                return ResponseFormatter::success(
                    $team,
                    'Data team berhasil diubah'
                );
            }
            return ResponseFormatter::error(
                'Data team tidak ada',
                404
            );
        } catch (Exception $error) {
            return ResponseFormatter::error(
                [
                    'message' => 'Something went wrong',
                    'error' => $error
                ],
                'Data team gagal diubah',
                500
            );
        }
    }
    public function delete($id){
        $team = Team::find($id);

        // check team is owned by user 
        if($team){
            $team->delete();
            return ResponseFormatter::success(
                $team,
                'Data team berhasil dihapus'
            );
        }
        return ResponseFormatter::error(
            'Data team tidak ada',
            404
        );
    }
    
}
