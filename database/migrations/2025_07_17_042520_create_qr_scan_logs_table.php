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
        Schema::create('qr_scan_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('staff_id')->constrained('staff')->onDelete('cascade');
            $table->foreignId('luggage_id')->constrained('luggage')->onDelete('cascade');
            $table->enum('action', ['Found', 'Found(unreported)', 'Updated']);
            $table->text('comment')->nullable();
            $table->string('scan_location')->nullable();
            $table->timestamp('scan_datetime')->useCurrent();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qr_scan_logs');
    }
};
