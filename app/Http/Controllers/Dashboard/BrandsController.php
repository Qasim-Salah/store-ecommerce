<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\BrandsType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\BrandRequest;
use App\Models\Brand as BrandModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BrandsController extends Controller
{
    public function index()
    {
        $brands = BrandModel::latest()->paginate(PAGINATION_COUNT);
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
                $request->request->add(['is_active' => BrandsType::UnActiveBrand]);
            else
                $request->request->add(['is_active' => BrandsType::ActiveBrand]);

            $fileName = "";
            if ($request->has('photo')) {
                ###helper###
                $fileName = uploadImage('brands', $request->photo);
            }

            $brand = BrandModel::create($request->except('_token'));

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
        $brand = BrandModel::findorfail($id);

        return view('dashboard.brands.edit', compact('brand'));

    }

    public function update($id, BrandRequest $request)
    {
        try {

            $brand = BrandModel::findorfail($id);

            DB::beginTransaction();
            if ($request->has('photo')) {
                $fileName = uploadImage('brands', $request->photo);
                BrandModel::where('id', $id)
                    ->update([
                        'photo' => $fileName,
                    ]);
            }

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => BrandsType::UnActiveBrand]);
            else
                $request->request->add(['is_active' => BrandsType::ActiveBrand]);

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
        $brand = BrandModel::findorfail($id);
        $image = Str::after($brand->photo, 'assets/images/brands');
        $image = public_path('assets/images/brands' . $image);
        unlink($image); //delete from folder
        if ($brand->delete())

            return redirect()->route('admin.brands')->with(['success' => 'تم  الحذف بنجاح']);

        return redirect()->route('admin.brands')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);

    }
}
