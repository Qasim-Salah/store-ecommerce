<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AdminRequest;
use App\Models\Admin as AdminModel;
use App\Models\Role as RoleModel;


class UsersController extends Controller
{

    public function index()
    {
        $users = AdminModel::latest()->where('id', '<>', auth()->id())->get(); //use pagination here
        return view('dashboard.users.index', compact('users'));
    }

    public function create()
    {
        $roles = RoleModel::select('id', 'name');
        return view('dashboard.users.create', compact('roles'));
    }


    public function store(AdminRequest $request)
    {

        $user = AdminModel::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id,
        ]);

        // save the new user data
        if ($user)
            return redirect()->route('admin.users.index')->with(['success' => 'تم التحديث بنجاح']);
        return redirect()->route('admin.users.index')->with(['success' => 'حدث خطا ما']);

    }
}
