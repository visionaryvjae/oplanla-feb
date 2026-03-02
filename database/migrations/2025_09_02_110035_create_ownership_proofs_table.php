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
        Schema::create('ownership_proofs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_id');
            $table->string('document_type');
            $table->string('ownership_proof_path');
            $table->enum('status',['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamps();

            $table->foreign('request_id')->references('id')->on('partner_requests');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ownership_proofs');
    }
};
