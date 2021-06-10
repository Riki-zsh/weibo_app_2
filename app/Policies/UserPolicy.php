<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * 授权方法 第一个参数无须传递 框架会自动加载 第二参数 传递操作的user
     * 自动注册 查看AuthServiceProvider
     * @param User $currentUser
     * @param User $user
     * @return bool
     */
    public function update(User $currentUser,User $user): bool
    {
        return $currentUser->id === $user->id;
    }
}
