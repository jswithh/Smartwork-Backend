<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateResponsibilityRequest;
use App\Http\Requests\UpdateResponsibilityRequest;
use App\Models\Responsibility;
use Exception;
use Illuminate\Http\Request;

class ResponsibilityController extends Controller
{
    public function fetch(Request $request){
        
        try {
            $id = $request->input('id');
            $name = $request->input('name');
            $limit = $request->input('limit', 10);
    
            $responsibilityQuery = Responsibility::query();
    
            // smartwork.id/api/responsibility?id=1
            if ($id) {
                $responsibility = $responsibilityQuery->find($id);
    
                if ($responsibility)
                    return ResponseFormatter::success(
                        $responsibility,
                        'Data responsibility berhasil diambil'
                    );
                
                    return ResponseFormatter::error(
                        'Data responsibility tidak ada',
                        404
                    );
            }
            // smartwork.id/api/responsibility
            $responsibility = $responsibilityQuery->where('role_id', $request->role_id);
    
            // smartwork.id/api/responsibility?name=hracademy
            if ($name){
    
                $responsibility->where('name', 'like', '%' . $name . '%');
            }
    
            return ResponseFormatter::success(
                $responsibility->paginate($limit),
                'Data list responsibility berhasil diambil'
            );
            
        } catch (Exception $error) {
            return ResponseFormatter::error(
                [
                    'message' => 'Something went wrong',
                    'error' => $error
                ],
                'Data responsibility gagal diambil',
                500
            );
        }
    }
    public function create(CreateResponsibilityRequest $request){
        try {
            $responsibility = Responsibility::create([
                'name' => $request->name,
                'role_id' => $request->role_id,
            ]);

        

            return ResponseFormatter::success(
                $responsibility,
                'Data responsibility berhasil ditambahkan'
            );

            
        } catch (Exception $error) {
            return ResponseFormatter::error(
                [
                    'message' => 'Something went wrong',
                    'error' => $error
                ],
                'Data responsibility gagal ditambahkan',
                500
            );
        }
    }

    public function update(UpdateResponsibilityRequest $request){
        try {
            $responsibility = Responsibility::find($request->id);

            // check responsibility is owned by user 
            if($responsibility){
                $responsibility->name = $request->name;
                $responsibility->role_id = $request->role_id;
                $responsibility->save();

                return ResponseFormatter::success(
                    $responsibility,
                    'Data responsibility berhasil diubah'
                );
            }
            return ResponseFormatter::error(
                'Data responsibility tidak ada',
                404
            );
        } catch (Exception $error) {
            return ResponseFormatter::error(
                [
                    'message' => 'Something went wrong',
                    'error' => $error
                ],
                'Data responsibility gagal diubah',
                500
            );
        }
    }
    public function delete($id){
        $responsibility = Responsibility::find($id);

        // check responsibility is owned by user 
        if($responsibility){
            $responsibility->delete();
            return ResponseFormatter::success(
                $responsibility,
                'Data responsibility berhasil dihapus'
            );
        }
        return ResponseFormatter::error(
            'Data responsibility tidak ada',
            404
        );
    }
    
}
