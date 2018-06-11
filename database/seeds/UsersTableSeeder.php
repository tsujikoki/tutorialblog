<?php

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
        DB::table('users')->insert([
        'name' => 'User 1',
        'login' => 'user1',
        'email' => 'user1@example.com',
        'password' => bcrypt('secret')
    ]);
    }
}
