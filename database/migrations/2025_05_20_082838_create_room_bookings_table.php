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
        Schema::create('room_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->dateTime('check_in_time');
            $table->dateTime('check_out_time');
            $table->integer('booking_price');
            $table->string('payment_status');
            $table->integer('transaction_id');
            $table->unsignedBigInteger('users_id');
            $table->timestamps();

            $table->foreign('users_id')
            ->references('id')
            ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_bookings');
    }
};
