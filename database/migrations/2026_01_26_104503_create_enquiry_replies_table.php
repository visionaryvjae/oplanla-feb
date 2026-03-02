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
        Schema::create('enquiry_replies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('enquiry_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('provider_user_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('message');
            $table->timestamps();
            
            $table->foreign('enquiry_id')->references('id')->on('enquiries');
            $table->foreign('provider_user_id')->references('id')->on('provider_users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enquiry_replies');
    }
};
