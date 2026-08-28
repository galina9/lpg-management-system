<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->delete();

        User::create([
            'name' => 'Director',
            'email' => 'director@ProGas MANAGEMENT SYSTEM.com',
            'password' => Hash::make('12345678'),
            'role' => 'director',
        ]);

        User::create([
            'name' => 'Manager',
            'email' => 'manager@ProGas MANAGEMENT SYSTEM.com',
            'password' => Hash::make('12345678'),
            'role' => 'manager',
        ]);

        User::create([
            'name' => 'Aram Driver',
            'email' => 'driver1@ProGas MANAGEMENT SYSTEM.com',
            'password' => Hash::make('12345678'),
            'role' => 'driver',
        ]);

        User::create([
            'name' => 'Hayk Driver',
            'email' => 'driver2@ProGas MANAGEMENT SYSTEM.com',
            'password' => Hash::make('12345678'),
            'role' => 'driver',
        ]);
    }
}