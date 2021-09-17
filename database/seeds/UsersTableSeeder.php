<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
                'user_name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin!@#'),
                'role' => 'admin',
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s'),
        ]);
        $user->assignRole(1);
    }
}
