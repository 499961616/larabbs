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
        User::factory()->count(20)->create();


        // 初始化用户角色，将 1 号用户指派为『站长』
        $user = User::find(1);
        $user->assignRole('Founder');

        // 将 2 号用户指派为『管理员』
        $user = User::find(2);
        $user->assignRole('Maintainer');

//    // 单独处理第一个用户的数据
//        $user = User::find(1);
//        $user->name = 'Summer';
//        $user->email = 'summer@example.com';
//        $user->avatar = 'https://cdn.learnku.com/uploads/images/201710/14/1/ZqM7iaP4CR.png';
//        $user->save();
    }
}
