<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('feedback', function (Blueprint $table) {
            //
            // Update enum values (keep only Pending and Resolved)
            DB::statement("ALTER TABLE feedback MODIFY COLUMN status ENUM('Pending','Responded') DEFAULT 'Pending'");

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feedback', function (Blueprint $table) {
            //
            // Revert to original enum if needed
            DB::statement("ALTER TABLE feedback MODIFY COLUMN status ENUM('Pending','In Progress','Resolved','Closed') DEFAULT 'Pending'");
        });
    }
};
