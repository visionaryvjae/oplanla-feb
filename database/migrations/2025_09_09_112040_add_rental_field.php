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
        Schema::table('rooms', function (Blueprint $table) {
            $table->boolean('rental')->default(false)->nullable();
            $table->integer('num_beds')->default(1)->nullable();
            $table->integer('num_bathrooms')->default(1)->nullable();
            $table->integer('rental_price')->nullable();
            $table->enum('furnishing', ['furnished', 'unfurnished', 'partially furnished'])->default('unfurnished')->nullable(); // e.g., 'Furnished', 'Unfurnished', 'Partially Furnished'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            //
        });
    }
};
