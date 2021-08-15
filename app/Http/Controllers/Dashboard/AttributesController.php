<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AttributeRequest;
use App\Models\Attribute as AttributeModel;
use App\Models\Brand as BrandModel;
use Illuminate\Support\Facades\DB;

class AttributesController extends Controller
{

    public function index()
    {
        $attributes = AttributeModel::latest()->paginate(PAGINATION_COUNT);
        return view('dashboard.attributes.index', compact('attributes'));
    }

    public function create()
    {
        return view('dashboard.attributes.create');
    }

    public function store(AttributeRequest $request)
    {
        try {

            DB::beginTransaction();
            $attribute = AttributeModel::create([]);

            //save translations
            $attribute->name = $request->name;
            $attribute->save();
            DB::commit();
            return redirect()->route('admin.attributes')->with(['success' => 'تم ألاضافة بنجاح']);
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->route('admin.attributes.create')->with(['error' => 'حدث خطأ ما']);
        }
    }

    public function edit($id)
    {
        $attribute = AttributeModel::findordfail($id);

        return view('dashboard.attributes.edit', compact('attribute'));

    }

    public function update($id, AttributeRequest $request)
    {
        try {

            $attribute = AttributeModel::findorfail($id);

            DB::beginTransaction();

            //save translations
            $attribute->name = $request->name;
            $attribute->save();

            DB::commit();
            return redirect()->route('admin.attributes')->with(['success' => 'تم ألتحديث بنجاح']);

        } catch (\Exception $ex) {

            DB::rollback();
            return redirect()->route('admin.attributes')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }

    public function destroy($id)
    {
        //get specific categories and its translations
        $attribute = BrandModel::findorfail($id);

        if ($attribute->delete())
            return redirect()->route('admin.attributes')->with(['success' => 'تم  الحذف بنجاح']);

        return redirect()->route('admin.attributes')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);

    }

}
