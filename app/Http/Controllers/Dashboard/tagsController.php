<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

use App\Http\Requests\TagsRequest;
use App\Models\Tag as TagModel;
use Illuminate\Support\Facades\DB;

class tagsController extends Controller
{
    public function index()
    {
        $tags = TagModel::orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        return view('dashboard.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('dashboard.tags.create');
    }


    public function store(TagsRequest $request)
    {
        try {

            DB::beginTransaction();

            $tag = TagModel::create(['slug' => $request->slug]);

            //save translations
            $tag->name = $request->name;
            $tag->save();
            DB::commit();
            return redirect()->route('admin.tags')->with(['success' => 'تم ألاضافة بنجاح']);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('admin.tags.create')->with(['error' => 'تم ألاضافة بنجاح']);

        }
    }

    public function edit($id)
    {
        $tag = TagModel::find($id);

        if (!$tag)
            return redirect()->route('admin.tags')->with(['error' => 'هذا الماركة غير موجود ']);

        return view('dashboard.tags.edit', compact('tag'));

    }

    public function update($id, TagsRequest $request)
    {
        try {

            $tag = TagModel::find($id);

            if (!$tag)
                return redirect()->route('admin.tags')->with(['error' => 'هذا الماركة غير موجود']);

            DB::beginTransaction();

            $tag->update($request->except('_token', 'id'));  // update only for slug column

            //save translations
            $tag->name = $request->name;
            $tag->save();

            DB::commit();
            return redirect()->route('admin.tags')->with(['success' => 'تم ألتحديث بنجاح']);

        } catch (\Exception $ex) {

            DB::rollback();
            return redirect()->route('admin.tags')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }

    public function destroy($id)
    {

        //get specific categories and its translations
        $tags = TagModel::find($id);

        if (!$tags)
            return redirect()->route('admin.tags')->with(['error' => 'هذا الماركة غير موجود ']);

        if ($tags->delete()) {

            return redirect()->route('admin.tags')->with(['success' => 'تم  الحذف بنجاح']);

        } else {
            return redirect()->route('admin.tags')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }

}
