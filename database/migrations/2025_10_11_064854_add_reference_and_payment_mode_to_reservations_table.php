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
        // only add columns if they don't already exist
        if (!Schema::hasColumn('reservations', 'reference_number')) {
            Schema::table('reservations', function (Blueprint $table) {
                $table->string('reference_number')->nullable()->after('payment_proof');
            });
        }

        if (!Schema::hasColumn('reservations', 'payment_mode')) {
            Schema::table('reservations', function (Blueprint $table) {
                $table->string('payment_mode')->nullable()->after('reference_number');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('reservations', 'payment_mode')) {
            Schema::table('reservations', function (Blueprint $table) {
                $table->dropColumn('payment_mode');
            });
        }

        if (Schema::hasColumn('reservations', 'reference_number')) {
            Schema::table('reservations', function (Blueprint $table) {
                $table->dropColumn('reference_number');
            });
        }
    }
};
