<?php

// namespace Database\Seeders;

// use Illuminate\Database\Seeder;
// use App\Models\Product;
// use Database\Seeders\ProductSeeder;

// class ProductSeeder extends Seeder
// {
//     public function run(): void
//     {
//         $this->call(ProductSeeder::class);
//         Product::insert([

//             [
//                 'name' => 'LPG Standard',
//                 'code' => 'LPG001',
//                 'gas_type' => 'LPG',
//                 'unit' => 'Liter',
//                 'purchase_price' => 220,
//                 'sale_price' => 250,
//                 'stock' => 5000,
//                 'status' => 'active',
//                 'description' => 'Standard LPG',
//                 'created_at' => now(),
//                 'updated_at' => now(),
//             ],

//             [
//                 'name' => 'Propane',
//                 'code' => 'PR001',
//                 'gas_type' => 'Propane',
//                 'unit' => 'Liter',
//                 'purchase_price' => 260,
//                 'sale_price' => 300,
//                 'stock' => 3000,
//                 'status' => 'active',
//                 'description' => 'Propane Gas',
//                 'created_at' => now(),
//                 'updated_at' => now(),
//             ],

//             [
//                 'name' => 'Butane',
//                 'code' => 'BT001',
//                 'gas_type' => 'Butane',
//                 'unit' => 'Kg',
//                 'purchase_price' => 180,
//                 'sale_price' => 220,
//                 'stock' => 1800,
//                 'status' => 'inactive',
//                 'description' => 'Butane',
//                 'created_at' => now(),
//                 'updated_at' => now(),
//             ]

//         ]);
//     }
// }

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ProductSeeder::class,
            CustomerSeeder::class,
        ]);
    }
}