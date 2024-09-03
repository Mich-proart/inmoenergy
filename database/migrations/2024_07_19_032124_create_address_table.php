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
            $table->foreignId('street_type_id')->nullable()->constrained('component_option');
            $table->foreignId('housing_type_id')->nullable()->constrained('component_option');
            $table->string('full_address')->nullable();
            $table->string('street_name')->nullable();
            $table->string('street_number')->nullable();
            $table->string('zip_code')->nullable();
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
