<?php

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

        User::create(['name' => 'Konstantins', 'email' => 'starovoitovs@gmail.com', 'password' => \Hash::make('admin')]);

        factory(App\Models\User::class, 20)->create();
    }
}
