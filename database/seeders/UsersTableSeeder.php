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
        User::insert([
            'login' => 'asdasd',
            'email' => 'asd@asd',
            'password' => bcrypt('asdasd'),
        ]);
        User::insert([
            'login' => 'asdasd1',
            'email' => 'asd@asd1',
            'password' => bcrypt('asdasd'),
        ]);
    }
}
