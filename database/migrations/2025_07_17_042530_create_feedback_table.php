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
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();

            $table->foreignId('traveler_id')->constrained('travelers')->onDelete('cascade');
            $table->string('subject')->nullable();
            $table->text('message');
            $table->enum('status', ['Pending', 'In Progress', 'Resolved', 'Closed'])->default('Pending');
            $table->text('admin_response')->nullable();
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamp('responded_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
