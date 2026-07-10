<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::create('products', function (Blueprint $table) {

        $table->id();

        // Product Information
        $table->string('name');
        $table->string('code')->unique();

        // Gas Type
        $table->enum('gas_type', [
            'LPG',
            'Propane',
            'Butane'
        ]);

        // Unit
        $table->enum('unit', [
            'Liter',
            'Kg',
            'Cylinder'
        ])->default('Cylinder');

        // Prices
        $table->decimal('purchase_price', 10, 2);
        $table->decimal('sale_price', 10, 2);

        // Stock
        $table->integer('stock')->default(0);

        // Status
        $table->enum('status', [
            'active',
            'inactive'
        ])->default('active');

        // Description
        $table->text('description')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
