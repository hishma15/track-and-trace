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
        //
        Schema::table('qr_codes', function (Blueprint $table) {
            // Modify qr_code_data to text
            $table->text('qr_code_data')->change();

            // Make pdf_path nullable
            $table->string('pdf_path')->nullable()->change();

            // Add index
            $table->index(['luggage_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('qr_codes', function (Blueprint $table) {
            // Revert qr_code_data to string (varchar)
            $table->string('qr_code_data')->change();

            // Make pdf_path not nullable again
            $table->string('pdf_path')->nullable(false)->change();

            // Drop the index
            $table->dropIndex(['luggage_id', 'is_active']);
        });

    }
};
