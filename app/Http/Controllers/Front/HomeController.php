<?php

namespace App\Http\Controllers\Front;


use App\Models\Category as CategoryModel;
use App\Models\Slider as SliderModel;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{

    public function home()
    {
        $data = [];
         $data['sliders'] = SliderModel::get(['photo']);
         $data['categories'] = CategoryModel::parent()->select('id', 'slug','photo')->with(['childrens' => function ($q) {
            $q->select('id', 'parent_id', 'slug','photo');
            $q->with(['childrens' => function ($qq) {
                $qq->select('id', 'parent_id', 'slug','photo');
            }]);
        }])->orderBy('id', 'DESC')->get();
        return view('front.home', $data);
    }
}
