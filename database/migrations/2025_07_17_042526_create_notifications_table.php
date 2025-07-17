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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('luggage_id')->nullable()->constrained('luggage')->onDelete('cascade');
            $table->string('notification_type');
            $table->string('title');
            $table->text('message');
            $table->json('data')->nullable(); // For additional data like staff info
            $table->boolean('is_read')->default(false);
            $table->boolean('is_email_sent')->default(false);
            $table->timestamp('sent_date')->useCurrent();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
