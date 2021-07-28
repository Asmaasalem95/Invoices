<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\User\Models\User;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create admin user
        User::create([
            'name' => 'admin',
            'email' => 'admin@mail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin@password'),  // password
            'remember_token' => Str::random(10),
            'role' => 'admin'
        ]);
        //create Application user
        User::create([
            'name' => 'john',
            'email' => 'user@mail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),  // password
            'remember_token' => Str::random(10),
            'role' => 'user'
        ]);
    }
}
