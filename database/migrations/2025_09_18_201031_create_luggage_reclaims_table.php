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
        Schema::create('luggage_reclaims', function (Blueprint $table) {
            $table->id();
            $table->foreignId('luggage_id')->constrained()->onDelete('cascade');
            $table->foreignId('traveler_id')->constrained()->onDelete('cascade');
            $table->foreignId('staff_id')->nullable()->constrained()->onDelete('set null');
            
            $table->string('collector_name');
            $table->string('collector_id_type');
            $table->string('collector_id_number');
            $table->string('collector_contact')->nullable();
            $table->string('relationship')->nullable();

            $table->string('otp_code')->nullable();
            $table->boolean('otp_verified')->default(false);
            $table->timestamp('reclaimed_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('luggage_reclaims');
    }
};
