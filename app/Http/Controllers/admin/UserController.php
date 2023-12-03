<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\role;
use Illuminate\Contracts\View\View;

class UserController extends Controller
{
    public function index()
    {

        $users = User::with('roles')->get();
        return view('admin.users.index', [
            "users" => $users
        ]);
    }

    public function edit(User $user)
    {
        $user->load('roles');
        $roles = role::all();
        return View('admin.users.edit', [
            "user" => $user,
            "roles" => $roles
        ]);
    }

    public function update(User $user, Request $request)
    {
        $request->validate(
            [
                'roles' => ['array', 'exists:roles,id']
            ]
        );
        $user->roles()->sync($request->input('roles'));
        return redirect()->route('admin.users.index');
    }
    public function remove(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('sucess', 'utilisateur supprimer');
    }

    public function show($id)
    {
        $users = User::findOrFail($id);
        return view('admin.users.show', compact('users'));
    }

}
