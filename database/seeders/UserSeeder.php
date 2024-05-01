<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Create a default user
         User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'role_id'=>1,
            'password' => Hash::make('password'),
        ]);


        User::create([
            'name' => 'employé',
            'email' => 'employé@example.com',
            'role_id'=>2,
            'password' => Hash::make('password'),
        ]);
        User::create([
            'name' => 'employé2',
            'email' => 'employé2@example.com',
            'role_id'=>2,
            'password' => Hash::make('password'),
        ]);

        // Create additional users

    }
}
