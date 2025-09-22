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
        Schema::table('luggage_reclaims', function (Blueprint $table) {
            // Drop the old staff_id foreign key and column
            if (Schema::hasColumn('luggage_reclaims', 'staff_id')) {
                $table->dropForeign(['staff_id']);
                $table->dropColumn('staff_id');
            }

            // Add user_id column referencing users table
            $table->unsignedBigInteger('user_id')->nullable()->after('traveler_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('luggage_reclaims', function (Blueprint $table) {
            // Drop the user_id foreign key and column
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

            // Re-add staff_id column (nullable) if needed
            $table->unsignedBigInteger('staff_id')->nullable()->after('traveler_id');
            $table->foreign('staff_id')->references('id')->on('staff')->onDelete('set null');
        });
    }
};
