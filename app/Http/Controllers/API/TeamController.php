<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\Team;
use Exception;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class TeamController extends Controller
{
    public function fetch(Request $request){
        $id = $request->input('id');
        $name = $request->input('name');
        $deparment_id = $request->input('deparment_id');
        $assigned = $request->input('assigned');
        $limit = $request->input('limit', 10);

        $teamQuery = Team::query()->with('department');

        // smartwork.id/api/team?id=1
       if($request->has('id')){
        $id = Hashids::decode($id);

        $teams = $teamQuery->where('id', $id)->get();

        if($teams->isNotEmpty()){
            return ResponseFormatter::success(
                $teams,
                'Data team berhasil diambil'
            );
        }
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
            $team->withCount('user');
        }

        if($request->has('department_id')){
            $deparment_id = Hashids::decode($deparment_id);
            $team =  $teamQuery->where('department_id', $deparment_id)->get();

            if($team){
                return ResponseFormatter::success(
                    $team,
                    'Data team berhasil diambil'
                );
            }
            return ResponseFormatter::error(
                'Data team tidak ada',
                404
            );
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
                'department_id' => $request->department_id,
                'icon' => $path,
            ]);

        

            return ResponseFormatter::success(
                $team,
                'Data team berhasil ditambahkan'
            );

            
        } catch (Exception $error) {
            return ResponseFormatter::error(
               $error->getMessage(),500
            );
        }
    }

    public function update(UpdateTeamRequest $request){
        try {
            $id = Hashids::decode($request->id)[0];
            $team = Team::find($id);

            // check team is owned by user 
            if($team){
                $team->name = $request->name;
                $team->department_id = $request->department_id;
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
        $id = Hashids::decode($id)[0];
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
