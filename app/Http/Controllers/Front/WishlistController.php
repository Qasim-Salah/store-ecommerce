<?php

namespace App\Http\Controllers\Front;

use App\Models\Category;

class WishlistController
{

    public function index()
    {
       $products =  auth()->user()
            ->wishlist()
            ->latest()
            ->get();   // task for you basically we need to use pagination here
        return view('front.wishlists', compact('products'));
    }

    public function store()
    {

        if (! auth()->user()->wishlistHas(request('productId'))) {
            auth()->user()->wishlist()->attach(request('productId'));
            return response() -> json(['status' => true , 'wished' => true]);
        }
        return response() -> json(['status' => true , 'wished' => false]);  // added before we can use enumeration here
    }

    public function destroy()
    {
        auth()->user()->wishlist()->detach(request('product_id'));
    }
}
