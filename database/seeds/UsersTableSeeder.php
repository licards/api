<?php

use App\Models\Role;
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // create super user
        $superUser = User::create([
            'name' => 'Konstantins',
            'email' => 'starovoitovs@gmail.com',
            'password' => Hash::make('admin')
        ]);

        // create admin role and attach it
        $adminRole = Role::create(['name' => 'admin']);
        $superUser->attachRole($adminRole);

        factory(App\Models\User::class, 20)->create();
    }
}
