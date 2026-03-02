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
        Schema::create('maintenance_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('specialty')->nullable(); // e.g., Plumber, Electrician
            $table->timestamps();
        });

        Schema::create('maintenance_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('rooms');
            $table->string('category'); // Plumbing, Electrical, etc.
            $table->text('description');
            $table->enum('status', ['pending', 'assigned', 'completed'])->default('pending');
            $table->timestamps();
        });


        Schema::create('maintenance_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maintenance_job_id')->constrained('maintenance_jobs');
            $table->foreignId('maintenance_user_id')->constrained('maintenance_users');
            $table->date('earliest_start_date')->nullable();
            $table->date('latest_completion_date')->nullable();
            $table->string('tenant_estimate')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->string('status')->default('in_progress');
            $table->string('completion_photo_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_tables');
    }
};
