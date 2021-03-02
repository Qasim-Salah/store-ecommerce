<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryRequest;
use App\Models\Category as CategoryModels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubCategoriesController extends Controller
{

    public function index()
    {
        $categories = CategoryModels::child()->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        return view('dashboard.subcategories.index', compact('categories'));
    }

    public function create()
    {
        $categories = CategoryModels::parent()->orderBy('id', 'DESC')->get();
        return view('dashboard.subcategories.create', compact('categories'));
    }


    public function store(SubCategoryRequest $request)
    {
        try {

            DB::beginTransaction();
            //validation
            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            $category = CategoryModels::create($request->except('_token'));

            //save translations
            $category->name = $request->name;
            $category->save();

            return redirect()->route('admin.subCategories')->with(['success' => 'تم ألاضافة بنجاح']);
            DB::commit();

        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('admin.subCategories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }


    public function edit($id)
    {


        //get specific categories and its translations
        $category = CategoryModels::orderBy('id', 'DESC')->find($id);

        if (!$category)
            return redirect()->route('admin.subCategories')->with(['error' => 'هذا القسم غير موجود ']);

        $categories = CategoryModels::parent()->orderBy('id', 'DESC')->get();


        return view('dashboard.subCategories.edit', compact('category', 'categories'));

    }


    public function update($id, SubCategoryRequest $request)
    {
        try {
            //validation

            //update DB


            $category = CategoryModels::find($id);

            if (!$category)
                return redirect()->route('admin.subCategories')->with(['error' => 'هذا القسم غير موجود']);

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            $category->update($request->all());

            //save translations
            $category->name = $request->name;
            $category->save();

            return redirect()->route('admin.subCategories')->with(['success' => 'تم ألتحديث بنجاح']);
        } catch (\Exception $ex) {

            return redirect()->route('admin.subCategories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }


    public function destroy($id)
    {


        //get specific categories and its translations
        $category = CategoryModels::orderBy('id', 'DESC')->find($id);

        if (!$category)
            return redirect()->route('admin.subCategories')->with(['error' => 'هذا القسم غير موجود ']);

        if ($category->delete()) {

            return redirect()->route('admin.subCategories')->with(['success' => 'تم  الحذف بنجاح']);

        } else {
            return redirect()->route('admin.subCategories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }

}
