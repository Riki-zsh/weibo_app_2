<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        //自定义授权规则
        //修改策略自动发现逻辑
        \Gate::guessPolicyNamesUsing(function ($modelClass){
            //动态返回模型对应的策略名称 如:App\Models\User => App\Policies\UserPolicy
            return "App\\Policies\\".class_basename($modelClass)."Policy";
        });
    }
}
