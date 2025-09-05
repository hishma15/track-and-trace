<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        // Add the column if it doesn't exist
        if (!Schema::hasColumn('qr_codes', 'unique_code')) {
            Schema::table('qr_codes', function (Blueprint $table) {
                $table->string('unique_code', 9)->nullable()->after('qr_image_path');
            });
        }

        // Generate unique codes for existing records
        $qrCodes = DB::table('qr_codes')
            ->whereNull('unique_code')
            ->orWhere('unique_code', '')
            ->get();

        foreach ($qrCodes as $qrCode) {
            do {
                $letters = Str::random(4);
                $numbers = rand(10000, 99999);
                $code = strtolower($letters) . $numbers;
            } while (DB::table('qr_codes')->where('unique_code', $code)->exists());

            DB::table('qr_codes')
                ->where('id', $qrCode->id)
                ->update(['unique_code' => $code]);
        }

        // Add unique constraint
        Schema::table('qr_codes', function (Blueprint $table) {
            $table->unique('unique_code');
        });
    }

    public function down(): void
    {
        Schema::table('qr_codes', function (Blueprint $table) {
            $table->dropUnique(['unique_code']);
            $table->dropColumn('unique_code');
        });
    }
};

