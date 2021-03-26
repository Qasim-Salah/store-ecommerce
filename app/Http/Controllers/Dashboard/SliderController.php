<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\SliderImagesRequest;
use App\Models\Slider as SliderModel;

class SliderController extends Controller
{

    public function index()
    {

        $images = SliderModel::get(['photo']);
        return view('dashboard.sliders.images.create', compact('images'));
    }

    public function store( SliderImagesRequest $request)
    {
        $fileName = "";
        if ($request->has('photo')) {
            ###helper###
            $fileName = uploadImage('sliders', $request->photo);
        }
       $slider= SliderModel::create(['photo'=>$fileName]);
        return redirect()->back()->with(['success' => 'تم التحديث بنجاح']);

    }


}
