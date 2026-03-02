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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('users_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('bookings_id');
            $table->unsignedBigInteger('providers_id');
            $table->unsignedTinyInteger('rating'); // Rating from 1 to 5
            $table->text('comment')->nullable();
            $table->timestamps();

            // Optional: A user can only review a provider once
            $table->unique(['users_id', 'bookings_id']);
            
            $table->foreign('users_id')
            ->references('id')
            ->on('users');

            $table->foreign('providers_id')
            ->references('id')
            ->on('providers');

            $table->foreign('bookings_id')
            ->references('id')
            ->on('room_bookings');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
