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
        Schema::table('photos', function (Blueprint $table) {
            $table->foreignId('rooms_id')->nullable()->references('id')->on('rooms')->onDelete('cascade');
            $table->dropForeign(['providers_id']);

            // 2. Change the column to be nullable
            // Use 'unsignedBigInteger' to match the default ID type
            $table->unsignedBigInteger('providers_id')->nullable()->change();

            // 3. Re-add the constraint
            $table->foreignId('providers_id')
                ->nullable()
                ->references('id')
                ->on('providers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('photos', function (Blueprint $table) {
            //
        });
    }
};
