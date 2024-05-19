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
            $table->foreignId('city_id')->constrained('city');
            $table->string('complement');
            $table->string('street_number');
            $table->string('zip_code');
            $table->string('bloq');
            $table->string('escal');
            $table->string('piso');
            $table->string('puert');
            $table->string('another');
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
