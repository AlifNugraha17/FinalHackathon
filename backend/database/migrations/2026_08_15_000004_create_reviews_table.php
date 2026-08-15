<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('place_id')->nullable()->constrained('places')->onDelete('cascade');
            $table->string('category_slug', 50)->default('medical'); // medical, dental, spa, golf, culinary
            $table->string('user_name', 100);
            $table->string('user_location', 100)->default('Singapore 🇸🇬'); // e.g. "Tampines, Singapore 🇸🇬"
            $table->string('user_avatar')->nullable();
            $table->string('treatment_name', 150); // e.g. "Executive Health Screening & EKG"
            $table->decimal('rating', 2, 1)->default(5.0); // 1.0 - 5.0
            $table->decimal('cost_saved_sgd', 10, 2)->default(0); // Amount saved in SGD compared to SG
            $table->decimal('spent_sgd', 10, 2)->default(0);
            $table->text('comment');
            $table->string('ferry_route', 150)->nullable(); // e.g. "HarbourFront SG ⇄ Harbour Bay (45 min)"
            $table->boolean('is_verified')->default(true);
            $table->unsignedInteger('helpful_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
