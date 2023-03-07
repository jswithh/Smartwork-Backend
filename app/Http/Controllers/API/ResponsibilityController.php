<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateResponsibilityRequest;
use App\Http\Requests\UpdateResponsibilityRequest;
use App\Models\Responsibility;
use Exception;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class ResponsibilityController extends Controller
{
    public function fetch(Request $request){
        
       
            $id = $request->input('id');
            $name = $request->input('name');
            $department_id = $request->input('department_id');
            $limit = $request->input('limit', 10);
    
            $responsibilityQuery = Responsibility::query();
    
            // smartwork.id/api/responsibility?id=1
            if ($id) {
                $responsibility = $responsibilityQuery->find($id);
    
                if ($responsibility){
                    return ResponseFormatter::success(
                        $responsibility,
                        'Data responsibility berhasil diambil'
                    );}
                
                    return ResponseFormatter::error(
                        'Data responsibility tidak ada',
                        404
                    );
            }
            // smartwork.id/api/responsibility
            $department_id = Hashids::decode($department_id);
            $responsibility = $responsibilityQuery->where('department_id', $department_id);
    
            // smartwork.id/api/responsibility?name=hracademy
            if ($name){
    
                $responsibility->where('name', 'like', '%' . $name . '%');
            }
    
            $responsibilities = $responsibility->paginate($limit);

            if($responsibilities->isNotEmpty()){
                return ResponseFormatter::success(
                    $responsibilities,
                    'Data responsibility berhasil diambil'
                );
            }

            return ResponseFormatter::error(
                'Data responsibility tidak ada',
                404
            );
            
        
    }
    public function create(CreateResponsibilityRequest $request){
        try {
            $responsibility = Responsibility::create([
                'name' => $request->name,
                'department_id' => $request->department_id,
            ]);

        

            return ResponseFormatter::success(
                $responsibility,
                'Data responsibility berhasil ditambahkan'
            );

            
        } catch (Exception $error) {
            return ResponseFormatter::error('Data responsibility gagal ditambahkan', 500);
        }
    }

    public function update(UpdateResponsibilityRequest $request, $id){
        try {
            
            $id = Hashids::decode($id)[0];
            $responsibility = Responsibility::find($id);
            // check responsibility is owned by user 
            if($responsibility){
                $responsibility->update($request->all());

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
                $error->getMessage(),
                500
            );
        }
    }
    public function delete($id){
        $id = Hashids::decode($id)[0];
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
