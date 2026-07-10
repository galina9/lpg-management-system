<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE orders
            MODIFY status ENUM(
                'Pending',
                'Assigned',
                'On Delivery',
                'Delivered',
                'Cancelled'
            ) DEFAULT 'Pending'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE orders
            MODIFY status ENUM(
                'Pending',
                'Completed',
                'Cancelled'
            ) DEFAULT 'Pending'
        ");
    }
};