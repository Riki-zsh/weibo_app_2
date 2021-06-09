<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Auth;

class UserController extends Controller
{
    /**
     * 注册页面
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * 用户信息
     * @param User $user
     * @return Application|Factory|View
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * 保存用户信息
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|unique:users|max:50',
            'email' => 'required|email|unique:users|max:225',
            'password' => 'required|confirmed|min:6'
        ]);
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
