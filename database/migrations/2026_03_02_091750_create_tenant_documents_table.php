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
        Schema::create('tenant_documents', function (Blueprint $table) {
            $table->id();
            $table->string('id_copy')->nullable();
            $table->string('pay_slips')->nullable();
            $table->string('bank_statements')->nullable();
            $table->string('proof_of_address')->nullable();
            $table->string('marriage_certificate')->nullable();
            $table->string('work_permit')->nullable();
            $table->text('comments')->nullable();
            $table->boolean('all_documents_verified')->default(false);
            $table->foreignId('users_id')->references('id')->on('users');
            $table->enum('status',['pending', 'verified', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_documents');
    }
};
