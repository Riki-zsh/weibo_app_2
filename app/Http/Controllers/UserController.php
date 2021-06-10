<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Auth;

class UserController extends Controller
{
    //构造方法 在一个类对象被创建之前该方法会被调用
    public function __construct()
    {
        //在构造方法调用middleware过滤请求 第一个参数中间件名称 第二个参数 动作
        //except 除了指定的方法不需要经过auth验证 其余方法都需要经过中间件验证
        //如果用户没有通过中间件认证 将重定向到登录页面
        $this->middleware('auth',[
            'except' => ['show','create','store']
        ]);
        //guest过滤只有未登录的用户能够访问注册页面
        $this->middleware('guest',[
            'only' => ['create']
        ]);
    }

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

    /**
     * 用户编辑页面
     * @param User $user
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function edit(User $user)
    {
        //authorize验证授权策略 参数一 传递策略方法 参数二 参数验证的数据model
        //需要授权策略逻辑代码 App\Policy
        $this->authorize('update',$user);
        return view('users.edit',compact('user'));
    }


    /**
     * 更新用户信息
     * @param User $user
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     * @throws AuthorizationException
     */
    public function update(User $user,Request $request):RedirectResponse
    {
        $this->authorize('update',$user);
        //校验数据
        $this->validate($request,[
            'name' => 'required | max:225',
            'password' => 'nullable | confirmed | min:5'
        ]);
        $data = [];
        $data['name'] = $request->name ?? '';
        if(!empty($request->password)){
            //密码加密bcrypt()
            $data['password'] =bcrypt($request->password);
        }
        //修改
        $user->update($data);
        //闪存保存信息 展示在页面
        session()->flash('success','个人资料更新完成!');
        return redirect()->route('user.show',$user);
    }
}
