<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Enumerations\CategoryType;
use App\Http\Requests\Dashboard\MainCategoryRequest;
use App\Models\Category;
use App\Models\Category as CategoryModel;
use Illuminate\Support\Facades\DB;

class MainCategoriesController extends Controller
{
    public function index()
    {
        $categories = CategoryModel::with('_parent')->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        return view('dashboard.categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = CategoryModel::select('id', 'parent_id')->orderBy('id', 'DESC')->get();
        return view('dashboard.categories.create', compact('categories'));
    }

    public function store(MainCategoryRequest $request)
    {
        try {

            DB::beginTransaction();

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => CategoryType::UnActiveCategory]);
            else
                $request->request->add(['is_active' => CategoryType::ActiveCategory]);

            $fileName = "";
            if ($request->has('photo')) {
                ###helper###
                $fileName = uploadImage('mainCategory', $request->photo);
            }

            //if user choose main category then we must remove paret id from the request
            if ($request->type == CategoryType::mainCategory) //main category
            {
                $request->request->add(['parent_id' => null]);
            }

            //if he choose child category we mus t add parent id

            $category = CategoryModel::create($request->except('_token'));

            //save translations
            $category->name = $request->name;
            $category->photo = $fileName;
            $category->save();

            DB::commit();
            return redirect()->route('admin.mainCategories')->with(['success' => 'تم ألاضافة بنجاح']);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('admin.mainCategories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }

    public function edit($id)
    {

        //get specific categories and its translations
        $category = CategoryModel::orderBy('id', 'DESC')->findorfail($id);

        return view('dashboard.categories.edit', compact('category'));

    }

    public function update($id, MainCategoryRequest $request)
    {
        try {

            $category = Category::findorfail($id);
            DB::beginTransaction();

            if ($request->has('photo')) {
                $fileName = uploadImage('mainCategory', $request->photo);
                CategoryModel::where('id', $id)
                    ->update([
                        'photo' => $fileName,
                    ]);
            }

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => CategoryType::UnActiveCategory]);
            else
                $request->request->add(['is_active' => CategoryType::ActiveCategory]);

            $category->update($request->all());

            //save translations
            $category->name = $request->name;
            $category->save();
            DB::commit();
            return redirect()->route('admin.mainCategories')->with(['success' => 'تم ألتحديث بنجاح']);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('admin.mainCategories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }


    }

    public function destroy($id)
    {
        //get specific categories and its translations
        $category = CategoryModel::orderBy('id', 'DESC')->findorfail($id);

        if ($category->delete())

            return redirect()->route('admin.mainCategories')->with(['success' => 'تم  الحذف بنجاح']);

        return redirect()->route('admin.mainCategories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);

    }
}
