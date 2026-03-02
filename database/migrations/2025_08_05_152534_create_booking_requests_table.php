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
        Schema::create('booking_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bookings_id')->onDelete('cascade');
            $table->unsignedBigInteger('users_id')->onDelete('cascade');
            $table->enum('type', ['cancellation', 'edit']);
            $table->text('message')->nullable(); // For edit requests
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();

            $table->foreign('users_id')
            ->references('id')
            ->on('users');

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
        Schema::dropIfExists('booking_requests');
    }
};
