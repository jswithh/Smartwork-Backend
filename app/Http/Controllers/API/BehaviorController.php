<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Behavior;
use App\Helpers\ResponseFormatter;
use Vinkla\Hashids\Facades\Hashids;

class BehaviorController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        $behavior = Behavior::create($request->all());

        if ($behavior) {
            return ResponseFormatter::success($behavior, 'Behavior Created');
        }

        return ResponseFormatter::error(null, 'Behavior Failed to Create');
    }

    public function fetch(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 10);
        $behavior = Behavior::query();

        if ($request->has('id')) {
            $id = Hashids::decode($id);
            $behavior = $behavior->where('id', $id)->get();

            if ($behavior->isNotEmpty()) {
                return ResponseFormatter::success($behavior, 'Behavior Found');
            }
            return ResponseFormatter::error('Behavior Not Found', 404);
        }

        $behaviors = $behavior->paginate($limit);
        if ($behaviors->isNotEmpty()) {
            return ResponseFormatter::success($behaviors, 'Behaviors Fetched');
        }
        return ResponseFormatter::error('Behaviors Not Found', 404);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $id = Hashids::decode($id)[0];
        $behavior = Behavior::find($id);

        if ($behavior) {
            $behavior->update($request->all());

            return ResponseFormatter::success($behavior, 'Behavior Updated');
        }

        return ResponseFormatter::error(null, 'Behavior Failed to Update');
    }

    public function delete($id)
    {
        $id = Hashids::decode($id)[0];
        $behavior = Behavior::find($id);

        if ($behavior) {
            $behavior->delete();

            return ResponseFormatter::success($behavior, 'Behavior Deleted');
        }

        return ResponseFormatter::error(null, 'Behavior Failed to Delete');
    }
}
