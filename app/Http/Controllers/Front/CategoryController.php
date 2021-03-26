<?php

namespace App\Http\Controllers\Front;

use App\Models\Category as CategoryModel;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function productsBySlug($slug)
    {
        $data = [];
        $data['category'] = CategoryModel::where('slug', $slug)->first();

        if ($data['category'])
            $data['products'] = $data['category']->products;

        return view('front.products', $data);
    }

}
