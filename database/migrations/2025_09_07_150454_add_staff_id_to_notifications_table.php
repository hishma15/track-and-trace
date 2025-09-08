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
        Schema::table('notifications', function (Blueprint $table) {
            //
            // nullable so existing rows won't break
            $table->unsignedBigInteger('staff_id')->nullable()->after('user_id');

            // add foreign key to users table (optional but recommended)
            $table->foreign('staff_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            //
            $table->dropForeign(['staff_id']);
            $table->dropColumn('staff_id');
        });
    }
};
