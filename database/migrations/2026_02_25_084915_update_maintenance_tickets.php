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
        Schema::table('maintenance_tickets', function (Blueprint $table) {
            $table->date('earliest_start_date')->nullable()->before('completed_at');
            $table->date('latest_completion_date')->nullable()->before('completed_at');
            $table->string('tenant_estimate')->nullable()->before('completed_at');
            $table->string('completion_photo_path')->nullable()->before('completed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maintenance_tickets', function (Blueprint $table) {
            $table->timestamp('started_at')->nullable();
            $table->decimal('price_charged', 10, 2)->nullable();
        });
    }
};
