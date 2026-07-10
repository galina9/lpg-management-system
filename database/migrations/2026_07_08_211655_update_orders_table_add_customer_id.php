<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            $table->foreignId('customer_id')
                  ->nullable()
                  ->after('product_id')
                  ->constrained()
                  ->nullOnDelete();

            $table->dropColumn([
                'customer_name',
                'customer_phone'
            ]);

        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            $table->string('customer_name');

            $table->string('customer_phone');

            $table->dropConstrainedForeignId('customer_id');

        });
    }
};