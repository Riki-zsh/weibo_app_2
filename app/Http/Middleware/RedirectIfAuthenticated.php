<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string|null ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                //当已登录用户访问限制的路由时 友好提示用户
                session()->flash('success',"你已经登录,无须再次操作!");
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
