<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::query()->delete();

        Product::insert([

            [
                'name' => 'Propane 10L',
                'code' => 'PR-10',
                'gas_type' => 'Propane',
                'unit' => 'Kg',
                'purchase_price' => 3000,
                'sale_price' => 3500,
                'stock' => 100,
                'status' => 'active',
                'description' => '10L Propane Cylinder',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Propane 27L',
                'code' => 'PR-27',
                'gas_type' => 'Propane',
                'unit' => 'Kg',
                'purchase_price' => 7600,
                'sale_price' => 8500,
                'stock' => 60,
                'status' => 'active',
                'description' => '27L Propane Cylinder',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Propane 50L',
                'code' => 'PR-50',
                'gas_type' => 'Propane',
                'unit' => 'Kg',
                'purchase_price' => 13000,
                'sale_price' => 14500,
                'stock' => 35,
                'status' => 'active',
                'description' => '50L Propane Cylinder',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Butane 27L',
                'code' => 'BT-27',
                'gas_type' => 'Butane',
                'unit' => 'Kg',
                'purchase_price' => 7100,
                'sale_price' => 7900,
                'stock' => 45,
                'status' => 'active',
                'description' => '27L Butane Cylinder',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Auto LPG',
                'code' => 'AUTO-LPG',
                'gas_type' => 'LPG',
                'unit' => 'Liter',
                'purchase_price' => 280,
                'sale_price' => 320,
                'stock' => 5000,
                'status' => 'active',
                'description' => 'Automotive LPG',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}