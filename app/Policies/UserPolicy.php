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

    /**
     * 删除用户策略 用户必须是管理员并且不能删除自己
     * @param User $currentUser
     * @param User $user
     * @return bool
     */
    public function destroy(User $currentUser, User $user): bool
    {
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }
}
