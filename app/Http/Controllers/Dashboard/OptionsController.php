<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\OptionsRequest;
use App\Models\Attribute as AttributeModel;
use App\Models\Brand as BrandModel;
use App\Models\Category as CategoryModel;
use App\Models\Option as OptionModel;
use App\Models\Product as ProductModel;
use Illuminate\Support\Facades\DB;

class OptionsController extends Controller
{

    public function index()
    {
        $options = OptionModel::with(['product' => function ($prod) {
            $prod->select('id');
        }, 'attribute' => function ($attr) {
            $attr->select('id');
        }])->select('id', 'product_id', 'attribute_id', 'price')->paginate(PAGINATION_COUNT);

        return view('dashboard.options.index', compact('options'));
    }

    public function create()
    {
        $data = [];
        $data['products'] = ProductModel::active()->select('id')->get();
        $data['attributes'] = AttributeModel::select('id')->get();

        return view('dashboard.options.create', $data);
    }

    public function store(OptionsRequest $request)
    {
        try {
            DB::beginTransaction();

            $option = OptionModel::create([
                'attribute_id' => $request->attribute_id,
                'product_id' => $request->product_id,
                'price' => $request->price,
            ]);
            //save translations
            $option->name = $request->name;
            $option->save();
            DB::commit();
            return redirect()->route('admin.options')->with(['success' => 'تم ألاضافة بنجاح']);

        } catch (\Exception $ex) {
            DB::rollBack();

            return redirect()->route('admin.options')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }

    public function edit($optionId)
    {
        $data = [];
        $data['option'] = OptionModel::findorfail($optionId);

        $data['products'] = ProductModel::active()->select('id')->get();
        $data['attributes'] = AttributeModel::select('id')->get();

        return view('dashboard.options.edit', $data);
    }

    public function update($id, OptionsRequest $request)
    {
        try {

            $option = OptionModel::findorfail($id);

            $option->update($request->only(['price', 'product_id', 'attribute_id']));
            //save translations
            $option->name = $request->name;
            $option->save();

            return redirect()->route('admin.options')->with(['success' => 'تم ألتحديث بنجاح']);
        } catch (\Exception $ex) {

            return redirect()->route('admin.options')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }


    public function destroy($id)
    {
        //
    }

}
