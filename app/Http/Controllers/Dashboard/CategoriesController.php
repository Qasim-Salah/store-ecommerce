<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\CategoryType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CategoryRequest;
use App\Models\Category as CategoryModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = CategoryModel::parent()->latest()->paginate(PAGINATION_COUNT);
        return view('dashboard.categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = CategoryModel::select('id', 'parent_id')->latest()->get();
        return view('dashboard.categories.create', compact('categories'));
    }

    public function store(CategoryRequest $request)
    {
        try {

            DB::beginTransaction();

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => CategoryType::UnActiveCategory]);
            $request->request->add(['is_active' => CategoryType::ActiveCategory]);

            $fileName = "";
            if ($request->has('photo')) {
                ###helper###
                $fileName = uploadImage('Category', $request->photo);
            }

            //if user choose main category then we must remove paret id from the request
            if ($request->type == CategoryType::mainCategory) //main category
                $request->request->add(['parent_id' => null]);


            //if he choose child category we mus t add parent id

            $category = CategoryModel::create($request->except('_token'));

            //save translations
            $category->name = $request->name;
            $category->photo = $fileName;
            $category->save();

            DB::commit();
            return redirect()->route('admin.Categories')->with(['success' => 'تم ألاضافة بنجاح']);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('admin.Categories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }

    public function edit($id)
    {

        //get specific categories and its translations
        $category = CategoryModel::latest()->findorfail($id);

        return view('dashboard.categories.edit', compact('category'));

    }

    public function update($id, CategoryRequest $request)
    {
        try {

            $category = CategoryModel::findorfail($id);
            DB::beginTransaction();

            if ($request->has('photo')) {
                $fileName = uploadImage('Category', $request->photo);
                CategoryModel::where('id', $id)
                    ->update([
                        'photo' => $fileName,
                    ]);
            }

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => CategoryType::UnActiveCategory]);
            $request->request->add(['is_active' => CategoryType::ActiveCategory]);

            $category->update($request->all());

            //save translations
            $category->name = $request->name;
            $category->save();
            DB::commit();
            return redirect()->route('admin.Categories')->with(['success' => 'تم ألتحديث بنجاح']);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('admin.Categories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }


    }

    public function destroy($id)
    {
        //get specific categories and its translations
        $category = CategoryModel::findorfail($id);

        $image = Str::after($category->photo, 'assets/images/Category');
        $image = public_path('assets/images/Category' . $image);
        unlink($image); //delete from folder
        if ($category->delete())
            return redirect()->route('admin.Categories')->with(['success' => 'تم  الحذف بنجاح']);

        return redirect()->route('admin.Categories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);

    }
}
