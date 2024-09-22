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
        User::create([
            'name' => '管理者',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);
        // ])->assignRole('admin');

        User::create([
            'name' => '店舗代表者',
            'email' => 'owner@owner.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'role' => 'shop_owner'
        ]);
        // ])->assignRole('shop_owner');

        User::create([
            'name' => '利用者',
            'email' => 'user@user.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'role' => 'user'
        ]);
        // ])->assignRole('user');
    }
}
