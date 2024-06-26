<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('address', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained('location');
            $table->foreignId('street_type_id')->constrained('street_type');
            $table->string('street_name');
            $table->string('street_number');
            $table->string('zip_code');
            $table->string('block')->nullable();
            $table->string('block_staircase')->nullable();
            $table->string('floor')->nullable();
            $table->string('door')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('address');
    }
};
