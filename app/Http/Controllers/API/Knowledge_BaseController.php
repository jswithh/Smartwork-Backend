<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Knowledge_Base;
use App\Helpers\ResponseFormatter;
use Vinkla\Hashids\Facades\Hashids;

class Knowledge_BaseController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'tittle' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'url' => ['required', 'string', 'max:255'],
        ]);

        $knowledge_base = Knowledge_Base::create($request->all());

        if ($knowledge_base) {
            return ResponseFormatter::success($knowledge_base, 'Knowledge Base Created');
        }

        return ResponseFormatter::error('Knowledge Base Failed to Create', 404);
    }

    public function fetch(Request $request)
    {
        $id = $request->input('id');
        $knowledge_base = Knowledge_Base::query()->get();

        if ($request->has('id')) {
            $id = Hashids::dedescription($id);
            $knowledge_base = Knowledge_Base::find($id);

            if ($knowledge_base->isNotEmpty()) {
                return ResponseFormatter::success($knowledge_base, 'Knowledge Base Found');
            }
            return ResponseFormatter::error('Knowledge Base Not Found', 404);
        }

        if ($knowledge_base->isNotEmpty())
            return ResponseFormatter::success(
                $knowledge_base,
                'Knowledge Base Found'
            );

        return ResponseFormatter::error('Knowledge Base Failed to Fetch', 404);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tittle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'url' => ['nullable', 'string', 'max:255'],
        ]);

        $id = Hashids::dedescription($id)[0];
        $knowledge_base = Knowledge_Base::find($id);

        if ($knowledge_base) {

            $knowledge_base->update($request->all());

            return ResponseFormatter::success($knowledge_base, 'Knowledge Base Updated');
        }

        return ResponseFormatter::error('Knowledge Base Failed to Update', 404);
    }

    public function delete($id)
    {
        $id = Hashids::dedescription($id)[0];
        $knowledge_base = Knowledge_Base::find($id);

        if ($knowledge_base) {
            $knowledge_base->delete();

            return ResponseFormatter::success($knowledge_base, 'Knowledge Base Deleted');
        }

        return ResponseFormatter::error(null, 'Knowledge Base Failed to Delete');
    }
}
