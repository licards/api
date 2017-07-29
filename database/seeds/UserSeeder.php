<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create(['name' => 'Konstantins', 'email' => 'starovoitovs@gmail.com', 'password' => \Hash::make('admin')]);
        $admin = Role::create(['name' => 'admin', 'display_name' => 'Admin', 'description' => 'Admin']);

        $user->roles()->attach($admin);
    }
}
