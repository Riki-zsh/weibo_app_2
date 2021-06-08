<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    //
    public function create()
    {
        return view('users.create');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $this->validate($request, [
                'name' => 'required|unique:users|max:50',
                'email' => 'required|email|unique:users|max:225',
                'password' => 'required|confirmed|min:6'
            ]);
        } catch (ValidationException $e) {
            echo $e;
        }
        $user = User::create([
            'name' => $request->name ?? '',
            'email' => $request->email ?? '',
            'password' => bcrypt($request->password ?? '')
        ]);
        session()->flash('success', "欢迎，您将在这里开启一段新的旅程~");
        return redirect()->route('user.show', [$user]);
    }
}
