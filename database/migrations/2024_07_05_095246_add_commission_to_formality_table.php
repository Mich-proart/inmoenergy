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
        Schema::table('formality', function (Blueprint $table) {
            $table->foreignId('product_id')->nullable()->constrained('product');
            $table->integer('commission')->nullable();
            $table->integer('potency')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('formality', function (Blueprint $table) {
            //
        });
    }
};
