<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Ferry Schedules Table
        Schema::create('ferry_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('operator_name', 100); // BatamFast, Majestic, Sindo, Horizon
            $table->foreignId('origin_terminal_id')->constrained('ferry_terminals')->onDelete('cascade');
            $table->foreignId('destination_terminal_id')->constrained('ferry_terminals')->onDelete('cascade');
            $table->time('departure_time');
            $table->time('arrival_time');
            $table->integer('duration_minutes')->default(45);
            $table->decimal('price_sgd', 8, 2)->default(43.00);
            $table->decimal('price_idr', 12, 2)->default(500000.00);
            $table->string('status', 50)->default('On Time'); // On Time, Boarding, Scheduled
            $table->string('days_active', 50)->default('Daily');
            $table->timestamps();
        });

        // 2. Fair Price Benchmarks Table (Anti-Getok & OCR Scanner)
        Schema::create('fair_price_benchmarks', function (Blueprint $table) {
            $table->id();
            $table->string('category', 100); // Kuliner Seafood, Perawatan Gigi, Medis, Spa, Transportasi
            $table->string('item_name', 150);
            $table->decimal('fair_price_min_idr', 12, 2);
            $table->decimal('fair_price_max_idr', 12, 2);
            $table->decimal('price_sgd_benchmark', 8, 2);
            $table->string('unit', 50)->default('per item');
            $table->decimal('warning_threshold_idr', 12, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 3. Specialist Doctors Table
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('place_id')->constrained('places')->onDelete('cascade');
            $table->string('name', 150);
            $table->string('specialization', 150);
            $table->string('degree', 200)->nullable();
            $table->string('languages_spoken', 200)->default('English, Bahasa Indonesia');
            $table->decimal('consultation_fee_sgd', 8, 2)->default(45.00);
            $table->decimal('consultation_fee_idr', 12, 2)->default(500000.00);
            $table->string('schedule_days', 150)->default('Senin - Jumat');
            $table->decimal('rating', 2, 1)->default(5.0);
            $table->string('avatar_url')->nullable();
            $table->timestamps();
        });

        // 4. Itinerary Packages Table (AI Travel Planner)
        Schema::create('itinerary_packages', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->string('theme', 100); // Medical & Spa, Golf & Relaxation, Food & Cafes
            $table->integer('duration_days')->default(2);
            $table->decimal('estimated_cost_sgd', 8, 2);
            $table->decimal('estimated_savings_sgd', 8, 2);
            $table->text('highlights');
            $table->json('steps_json')->nullable();
            $table->string('image_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('itinerary_packages');
        Schema::dropIfExists('doctors');
        Schema::dropIfExists('fair_price_benchmarks');
        Schema::dropIfExists('ferry_schedules');
    }
};
