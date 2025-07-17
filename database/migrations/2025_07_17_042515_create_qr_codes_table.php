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
        Schema::create('qr_codes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('luggage_id')->constrained('luggage')->onDelete('cascade');
            $table->string('qr_code_data');
            $table->string('qr_image_path');
            $table->string('pdf_path');
            $table->boolean('is_active')->default(true);
            $table->timestamp('date_created')->useCurrent();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qr_codes');
    }
};
