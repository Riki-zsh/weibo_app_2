<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Auth;

class UserController extends Controller
{
    //创建用户页面
    public function create()
    {
        return view('users.create');
    }

    //展示用户详细信息
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    //保存用户信息
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
        Auth::login($user);
        session()->flash('success', "欢迎，您将在这里开启一段新的旅程~");
        return redirect()->route('user.show', [$user]);
    }
}
