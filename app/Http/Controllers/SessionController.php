<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Auth;
class SessionController extends Controller
{
    /**
     * 创建登录页面
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('sessions.create');
    }

    /**
     * 登录(创建新会话)
     * @param Request $request
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required | email | max:225', //必填 | 验证邮箱 | 最大长度225
            'password' => 'required'
        ]);
        //attempt校验登录数据 成功返回true 失败返回false
        if(Auth::attempt($credentials)){
            //校验数据成功后 执行登录逻辑代码
            session()->flash('success',"登录成功,欢迎回来!");
            //登录成功后 可以通过Auth::user 获取当前登录用户的信息 redirect重定向到当前用户详细信息
            return redirect()->route('user.show',[Auth::user()]);
        }else{
            //校验数据失败 提示用户信息
            session()->flash('danger',"抱歉,邮箱和密码不匹配或没有此邮箱账号!");
            //登录失败 重定向到登录页面 并保留当前用户输入的内容 withInput()
            return redirect()->back()->withInput();
        }
    }

    /**
     * 销毁会话,退出登录
     */
    public function destroy()
    {

    }
}
