<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting as SettingModel;
use Illuminate\Http\Request;

class SettingsController extends Controller
{

    public function editShippingMethods($type)
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

    public function updateShippingMethods(Request $request , $id){

    }
}
