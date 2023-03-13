<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategory_KnowledgeRequest;
use App\Http\Requests\UpdateCategory_KnowledgeRequest;
use App\Models\Category_Knowledge;
use Exception;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class Category_KnowledgeController extends Controller
{
    public function fetch(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $limit = $request->input('limit', 10);

        $category_knowledgeQuery = Category_Knowledge::query();

        // smartwork.id/api/category_knowledge?id=1
        if ($request->has('id')) {
            $id = Hashids::decode($id);

            $category_knowledges = $category_knowledgeQuery->where('id', $id)->get();

            if ($category_knowledges->isNotEmpty()) {
                return ResponseFormatter::success(
                    $category_knowledges,
                    'Data category_knowledge berhasil diambil'
                );
            }
            return ResponseFormatter::error(
                'Data category knowledge tidak ada',
                404
            );
        }
        // smartwork.id/api/category_knowledge
        $category_knowledge = $category_knowledgeQuery->paginate($limit);

        // smartwork.id/api/category_knowledge?name=hracademy
        if ($name) {
            $category_knowledge->where('name', 'like', '%' . $name . '%');
        }


        if ($category_knowledge->isNotEmpty()) {
            return ResponseFormatter::success(
                $category_knowledge,
                'Data category knowledge berhasil diambil'
            );
        }
        return ResponseFormatter::error(
            'Data category knowledge tidak ada',
            404
        );
    }
    public function create(CreateCategory_KnowledgeRequest $request)
    {

        if ($request->file('icon')) {
            $path = url('/') . '/storage/category_knowledge_icon/' . $request->file('icon')->hashName();
            $request->file('icon')->store('public/category_knowledge_icon');
        }

        $data = $request->all();
        $data['icon'] = isset($path) ? $path : null;

        $category_knowledge = Category_Knowledge::create($data);
        return ResponseFormatter::success(
            $category_knowledge,
            'Data category_knowledge berhasil ditambahkan'
        );
    }

    public function update(UpdateCategory_KnowledgeRequest $request)
    {

        $id = Hashids::decode($request->id)[0];
        $category_knowledge = Category_Knowledge::find($id);

        // check category_knowledge is owned by user
        $data = $request->all();
        if ($request->file('icon')) {
            $path = url('/') . '/storage/category_knowledge_icon/' . $request->file('icon')->hashName();
            $request->file('icon')->store('public/category_knowledge_icon');
            $data['icon'] = $path;
        }



        if ($category_knowledge) {
            $category_knowledge->update($data);

            return ResponseFormatter::success(
                $category_knowledge,
                'Data category_knowledge berhasil diubah'
            );
        }
        return ResponseFormatter::error(
            'Data category_knowledge tidak ada',
            404
        );
    }
    public function delete($id)
    {
        $id = Hashids::decode($id)[0];
        $category_knowledge = Category_Knowledge::find($id);

        // check category_knowledge is owned by user 
        if ($category_knowledge) {
            $category_knowledge->delete();
            return ResponseFormatter::success(
                $category_knowledge,
                'Data category_knowledge berhasil dihapus'
            );
        }
        return ResponseFormatter::error(
            'Data category_knowledge tidak ada',
            404
        );
    }
}
