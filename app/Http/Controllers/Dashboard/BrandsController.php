<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand as BrandModel;
use Illuminate\Support\Facades\DB;

class BrandsController extends Controller
{
    public function index()
    {
        $brands = BrandModel::orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        return view('dashboard.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('dashboard.brands.create');
    }


    public function store(BrandRequest $request)
    {
        try {
            DB::beginTransaction();
            //validation
            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            $fileName = "";
            if ($request->has('photo')) {
                ###helper###
                $fileName = uploadImage('brands', $request->photo);
            }

            $brand = BrandModel::create($request->except('_token', 'photo'));

            //save translations
            $brand->name = $request->name;
            $brand->photo = $fileName;

            $brand->save();
            DB::commit();
            return redirect()->route('admin.brands')->with(['success' => 'تم ألاضافة بنجاح']);
        } catch (\Exception $ex) {

            DB::rollback();
            return redirect()->route('admin.brands.create')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }

    public function edit($id)
    {
        //get specific categories and its translations
        $brand = BrandModel::find($id);

        if (!$brand)
            return redirect()->route('admin.brands')->with(['error' => 'هذا الماركة غير موجود ']);

        return view('dashboard.brands.edit', compact('brand'));

    }

    public function update($id, BrandRequest $request)
    {
        try {

            $brand = BrandModel::find($id);

            if (!$brand)
                return redirect()->route('admin.brands')->with(['error' => 'هذا الماركة غير موجود']);

            DB::beginTransaction();
            if ($request->has('photo')) {
                $fileName = uploadImage('brands', $request->photo);
                BrandModel::where('id', $id)
                    ->update([
                        'photo' => $fileName,
                    ]);
            }

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            $brand->update($request->except('_token', 'id', 'photo'));

            //save translations
            $brand->name = $request->name;
            $brand->save();

            DB::commit();
            return redirect()->route('admin.brands')->with(['success' => 'تم ألتحديث بنجاح']);

        } catch (\Exception $ex) {

            DB::rollback();
            return redirect()->route('admin.brands')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }

    public function destroy($id)
    {
        $brand = BrandModel::find($id);

        if (!$brand)
            return redirect()->route('admin.brands')->with(['error' => 'هذا الماركة غير موجود ']);

        if ($brand->delete()) {

            return redirect()->route('admin.brands')->with(['success' => 'تم  الحذف بنجاح']);

        } else {
            return redirect()->route('admin.brands')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }
}
