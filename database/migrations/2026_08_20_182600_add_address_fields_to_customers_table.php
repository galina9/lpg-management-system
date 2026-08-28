<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {

            if (!Schema::hasColumn('customers', 'region')) {
                $table->string('region')->nullable()->after('phone');
            }

            if (!Schema::hasColumn('customers', 'city')) {
                $table->string('city')->nullable()->after('region');
            }

            if (!Schema::hasColumn('customers', 'address')) {
                $table->string('address')->nullable()->after('city');
            }

            if (!Schema::hasColumn('customers', 'apartment')) {
                $table->string('apartment')->nullable()->after('address');
            }

        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {

            $columns = [];

            if (Schema::hasColumn('customers', 'region')) {
                $columns[] = 'region';
            }

            if (Schema::hasColumn('customers', 'city')) {
                $columns[] = 'city';
            }

            if (Schema::hasColumn('customers', 'address')) {
                $columns[] = 'address';
            }

            if (Schema::hasColumn('customers', 'apartment')) {
                $columns[] = 'apartment';
            }

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }

        });
    }
};