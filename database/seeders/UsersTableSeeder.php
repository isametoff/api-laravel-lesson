<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            'password' => Hash::make('asdasd'),
            'balance' => 1000,
        ]);
        User::insert([
            'login' => 'asdasd1',
            'password' => Hash::make('asdasd1'),
            'balance' => 1000,
        ]);
    }
}
