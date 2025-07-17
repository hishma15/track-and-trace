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
        Schema::create('luggage', function (Blueprint $table) {
            $table->id();

            $table->foreignId('traveler_id')->constrained('travelers')->onDelete('cascade');
            $table->string('image_path')->nullable();
            $table->string('color');
            $table->string('brand_type');
            $table->text('description')->nullable();
            // $table->string('size')->nullable();
            $table->text('unique_features')->nullable();
            $table->enum('status', ['Safe', 'Lost', 'Found', 'Found(unreported)'])->default('Safe');
            $table->string('lost_station');
            $table->timestamp('date_registered')->useCurrent();
            $table->timestamp('date_lost')->nullable();
            $table->timestamp('date_found')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('luggage');
    }
};
