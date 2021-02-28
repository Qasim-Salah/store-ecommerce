<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\Admin as AdminModel;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {

        $admin = AdminModel::find(auth('admin')->user()->id);

        return view('dashboard.profile.edit', compact('admin'));

    }

    public function update(ProfileRequest $request)
    {
        //validate
        // db
        $admin = AdminModel::find(auth('admin')->user()->id);


        if ($request->filled('password')) {
            $request->merge(['password' => bcrypt($request->password)]);
        }

        unset($request['id']);
        unset($request['password_confirmation']);

        if ($admin->update($request->all())) {

            return redirect()->back()->with(['success' => 'تم التحديث بنجاح']);

        } else {
            return redirect()->back()->with(['error' => 'هناك خطا ما يرجي المحاولة فيما بعد']);

        }

    }

}
