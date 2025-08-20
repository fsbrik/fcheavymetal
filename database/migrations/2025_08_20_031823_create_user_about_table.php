<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_about', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();

            // Multiple musical styles (puede ser JSON o relación N:N, aquí JSON para simplificar)
            $table->json('musical_styles')->nullable();

            // Religion
            $table->enum('religion', [
                'atheist/agnostic',
                'satanist',
                'pagan',
                'jewish',
                'islamic',
                'christian',
                'other',
            ])->nullable();

            // Investment availability
            $table->enum('investment_range', [
                'less_than_5000',
                '5001_10000',
                '10001_25000',
                '25001_50000',
                '50001_100000',
                'more_than_100000',
            ])->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_about');
    }
};
