<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Enable PostGIS Spatial Extension for PostgreSQL if available on server
        $hasPostgis = false;
        if (DB::getDriverName() === 'pgsql') {
            try {
                $ext = DB::select("SELECT 1 FROM pg_available_extensions WHERE name = 'postgis'");
                if (!empty($ext)) {
                    DB::statement('CREATE EXTENSION IF NOT EXISTS postgis;');
                    $hasPostgis = true;
                }
            } catch (\Throwable $e) {
                $hasPostgis = false;
            }
        }

        // 2. Categories Table
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 50)->unique(); // medical, dental, spa, golf, culinary
            $table->string('name', 100);
            $table->string('icon', 50)->nullable();
            $table->timestamps();
        });

        // 3. Ferry Terminals Table
        Schema::create('ferry_terminals', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 50)->unique(); // harbour-bay, batam-centre, sekupang, nongsa
            $table->string('name', 100);
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 4. Places & Medical Centers Table
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('ferry_terminal_id')->nullable()->constrained('ferry_terminals')->onDelete('set null');
            $table->string('name', 150);
            $table->text('description');
            $table->text('address');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->decimal('price_sgd', 10, 2);
            $table->integer('savings_percent')->default(50);
            $table->decimal('rating', 2, 1)->default(5.0);
            $table->string('image_url')->nullable();
            $table->timestamps();
        });

        // Add Spatial Location Column in PostgreSQL PostGIS if available
        if ($hasPostgis) {
            try {
                $extActive = DB::select("SELECT 1 FROM pg_extension WHERE extname = 'postgis'");
                if (!empty($extActive)) {
                    DB::statement("SELECT AddGeometryColumn('places', 'location', 4326, 'POINT', 2);");
                    DB::statement("CREATE INDEX places_location_spatial_idx ON places USING GIST (location);");
                }
            } catch (\Throwable $e) {
                // PostGIS not active; continue with latitude/longitude
            }
        }

        // 5. Bookings Table
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('place_id')->nullable()->constrained('places')->onDelete('set null');
            $table->string('user_name', 100);
            $table->string('user_email', 100);
            $table->string('user_phone', 50);
            $table->date('booking_date');
            $table->time('booking_time');
            $table->boolean('pickup_required')->default(false);
            $table->foreignId('pickup_terminal_id')->nullable()->constrained('ferry_terminals')->onDelete('set null');
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('places');
        Schema::dropIfExists('ferry_terminals');
        Schema::dropIfExists('categories');
    }
};
