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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('pop_path')->nullable(); // Storage path for the PoP file
            $table->string('payment_type');
            $table->integer('amount');
            $table->enum('status', ['unpaid', 'pending_verification', 'paid', 'rejected'])
                ->default('unpaid');
            $table->string('invoice_number');
            $table->foreignId('provider_id')->references('id')->on('providers');
            $table->foreignId('tenant_id')->references('id')->on('users');
            $table->foreignId('charge_id')->nullable()->references('id')->on('charges');
            $table->timestamp('uploaded_at')->nullable();
            $table->timestamp('verified_at')->nullable(); 
            $table->timestamps();  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
