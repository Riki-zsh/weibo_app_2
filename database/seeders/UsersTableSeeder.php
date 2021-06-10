<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //User::factory() 返回一个UserFactory对象 count 指定数量
        User::factory()->count(50)->create();
        $user = (new \App\Models\User)->find(1);
        $user->name = 'admin';
        $user->email = "admin@qq.com";
        $user->password = bcrypt('admin');
        $user->is_admin = true;
        $user->save();
    }
}
