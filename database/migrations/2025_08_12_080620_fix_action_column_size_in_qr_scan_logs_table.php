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
        Schema::table('qr_scan_logs', function (Blueprint $table) {
            //
            // Increase the action column size to accommodate longer action names
            $table->string('action', 50)->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('qr_scan_logs', function (Blueprint $table) {
            //
             // Revert back to smaller size (adjust based on your original size)
            $table->string('action', 20)->change();
        });
    }
};
