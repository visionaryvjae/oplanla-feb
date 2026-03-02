<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_utility_tables.php

    public function up()
    {
        // 1. Meters Table (Links to your 'rooms' table)
        Schema::create('meters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rooms_id')->constrained('rooms')->onDelete('cascade');
            $table->string('serial_number')->unique(); // The 'MeterNo' from Motla
            $table->enum('type', ['electricity', 'water']);
            $table->decimal('multiplier', 8, 2)->default(1.00); // For industrial/bulk meters
            $table->timestamps();
        });

        // 2. Tariffs Table (Stores the SA Tiered Rates)
        Schema::create('tariffs', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "CoJ Domestic Step 1"
            $table->enum('type', ['electricity', 'water']);
            $table->decimal('block_limit', 10, 2)->nullable(); // e.g., 350 (kWh)
            $table->decimal('price_per_unit', 10, 4); // Rand value
            $table->integer('tier_level'); // 1, 2, or 3
            $table->timestamps();
        });

        // 3. Meter Readings Table
        Schema::create('meter_readings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meter_id')->constrained('meters');
            $table->decimal('reading_value', 15, 2);
            $table->date('reading_date');
            $table->string('source')->default('manual'); // 'manual' or 'Motla_Import'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utiltity_tables');
    }
};
