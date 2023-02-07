<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\CreateCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function fetch(Request $request){
        $id = $request->input('id');
        $name = $request->input('name');
        $limit = $request->input('limit', 10);

        // smartwork.id/api/company?id=1
        if ($id) {
            $company = Company::whereHas('users', function($user){
                $user->where('user_id', Auth::id());
            })->with(['users'])->find($id);

            if ($company){
                return ResponseFormatter::success(
                    $company,
                    'Data company berhasil diambil'
                );
            }
           
                return ResponseFormatter::error(
                    'Data company tidak ada',
                    404
                );
        }
        // smartwork.id/api/company
        $company = Company::whereHas('users', function($user){
            $user->where('user_id', Auth::id());
        });

        // smartwork.id/api/company?name=hracademy
        if ($name){

            $company->where('name', 'like', '%' . $name . '%');
        }

        return ResponseFormatter::success(
            $company->paginate($limit),
            'Data list company berhasil diambil'
        );
    }

    public function create(CreateCompanyRequest $request){
        try {
            if($request->file('logo')){
                $path = $request->file('logo')->store('public/company_logo');
            }
            $company = Company::create([
                'name' => $request->name,
                'logo' => $path,
            ]);

            $user = User::find(Auth::id());
            $user->companies()->attach($company->id);
            $company->load('users');

            return ResponseFormatter::success(
                $company,
                'Data company berhasil ditambahkan'
            );
        } catch (Exception $error) {
            return ResponseFormatter::error(
                [
                    'message' => 'Something went wrong',
                    'error' => $error
                ],
                'Data company gagal ditambahkan',
                500
            );
        }
    }

    public function update(UpdateCompanyRequest $request, $id){
        try {
            $company = Company::find($id);
            
            if(!$company)
                return ResponseFormatter::error(
                    null,
                    'Data company tidak ada',
                    404
                );

            if($request->hasFile('logo')){
                $path = $request->file('logo')->store('public/company_logo');
            }
            $company->update([
                'name' => $request->name,
                'logo' => $path
            ]);

            return ResponseFormatter::success(
                $company,
                'Data company berhasil diubah'
            );
        } catch (Exception $error) {
            return ResponseFormatter::error($error->getMessage(),500);
        } 
    }

    public function delete($id){
        try {
            $company = Company::find($id);
            
            if(!$company)
                return ResponseFormatter::error(
                    null,
                    'Data company tidak ada',
                    404
                );

            $company->delete();

            return ResponseFormatter::success(
                $company,
                'Data company berhasil dihapus'
            );
        } catch (Exception $error) {
            return ResponseFormatter::error($error->getMessage(),500);
        } 
    }
}
