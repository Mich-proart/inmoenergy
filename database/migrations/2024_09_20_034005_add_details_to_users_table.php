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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('incentive_type_id')->nullable()->constrained('component_option');
            $table->foreignId('office_id')->nullable()->constrained('office');
            $table->foreignId('document_type_id')->nullable()->constrained('component_option');
            $table->foreignId('address_id')->nullable()->constrained('address');
            $table->foreignId('country_id')->nullable()->constrained('country');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
