<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\User as UserModel;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = UserModel::findorfail(auth()->user()->id);

        return view('front.profile.edit', compact('user'));
    }

    public function update(ProfileRequest $request)
    {
        //validate
        // db
        $user = UserModel::findorfail(auth()->user()->id);

        if ($request->filled('password')) {
            $request->merge(['password' => bcrypt($request->password)]);
        }

        unset($request['id']);
        unset($request['password_confirmation']);

        if ($user->update($request->all()))

            return redirect()->route('home')->with(['success' => 'تم التحديث بنجاح']);

        return redirect()->back()->with(['error' => 'هناك خطا ما يرجي المحاولة فيما بعد']);


    }

}
