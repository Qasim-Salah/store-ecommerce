<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ShippingsRequest;
use App\Models\Setting as SettingModel;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function edit($type)
    {
        //free , inner , outer for shipping methods

        if ($type === 'free')
            $shippingMethod = SettingModel::where('key', 'free_shipping_label')->first();

        elseif ($type === 'inner')
            $shippingMethod = SettingModel::where('key', 'local_label')->first();

        elseif ($type === 'outer')
            $shippingMethod = SettingModel::where('key', 'outer_label')->first();
        else
            $shippingMethod = SettingModel::where('key', 'free_shipping_label')->first();

        return view('dashboard.settings.shippings.edit', compact('shippingMethod'));

    }

    public function update(ShippingsRequest $request, $id)
    {
        //validation

        //update db

        try {
            $shipping_method = SettingModel::findorfail($id);
            DB::beginTransaction();

            $shipping_method->update(['plain_value' => $request->plain_value]);
            //save translations

            $shipping_method->value = $request->value;
            $shipping_method->save();

            DB::commit();
            return redirect()->back()->with(['success' => 'تم التحديث بنجاح']);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(['error' => 'هناك خطا ما يرجي المحاولة فيما بعد']);

        }

    }

}
