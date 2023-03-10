<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Reminder_Type;
use App\Helpers\ResponseFormatter;

use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class Reminder_TypeController extends Controller
{
    public function create(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $Reminder_Type = Reminder_Type::create($request->all());


        if ($Reminder_Type) {
            return ResponseFormatter::success($Reminder_Type, 'Reminder type Created');
        }

        return ResponseFormatter::error(null, 'Reminder type Failed to Create');
    }

    public function fetch(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 10);

        // get multiple data
        $Reminder_TypeQuery = Reminder_Type::query();

        // get single data

        if ($request->has('id')) {
            $id = Hashids::decode($id);
            $Reminder_Type = $Reminder_TypeQuery->where('id', $id)->get();

            if ($Reminder_Type->isNotEmpty()) {
                return ResponseFormatter::success($Reminder_Type, 'Reminder type Found');
            }
            return ResponseFormatter::error('Reminder type Not Found', 404);
        }
        $Reminder_Type = $Reminder_TypeQuery->paginate($limit);
        if ($Reminder_Type->isNotEmpty()) {
            return ResponseFormatter::success($Reminder_Type, 'Reminder type Found');
        }
        return ResponseFormatter::error('Reminder type Not Found', 404);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
        ]);
        $id = Hashids::decode($id)[0];
        $Reminder_Type = Reminder_Type::find($id);

        if ($Reminder_Type) {
            $Reminder_Type->update(
                $request->all()
            );

            return ResponseFormatter::success($Reminder_Type, 'Reminder type Updated');
        }

        return ResponseFormatter::error(null, 'Reminder type Failed to Update');
    }

    public function delete($id)
    {
        $id = Hashids::decode($id)[0];
        $Reminder_Type = Reminder_Type::find($id);

        if ($Reminder_Type) {
            $Reminder_Type->delete();

            return ResponseFormatter::success($Reminder_Type, 'Reminder type Deleted');
        }

        return ResponseFormatter::error('Reminder type Failed to Delete', 404);
    }
}
