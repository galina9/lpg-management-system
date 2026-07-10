<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        Customer::query()->delete();

        Customer::insert([

            [
                'full_name' => 'Armen Petrosyan',
                'phone' => '+37499111111',
                'email' => 'armen@example.com',
                'address' => 'Yerevan, Arabkir',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'full_name' => 'Anna Harutyunyan',
                'phone' => '+37499222222',
                'email' => 'anna@example.com',
                'address' => 'Yerevan, Kentron',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'full_name' => 'Hayk Sargsyan',
                'phone' => '+37493333333',
                'email' => 'hayk@example.com',
                'address' => 'Gyumri',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'full_name' => 'Mariam Avetisyan',
                'phone' => '+37494444444',
                'email' => 'mariam@example.com',
                'address' => 'Vanadzor',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'full_name' => 'Karen Mkrtchyan',
                'phone' => '+37495555555',
                'email' => 'karen@example.com',
                'address' => 'Abovyan',
                'status' => 'inactive',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}