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
        Schema::create('client', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('first_last_name')->nullable();
            $table->string('second_last_name')->nullable();
            $table->string('email')->unique();
            $table->foreignId('client_type_id')->nullable()->constrained('component_option');
            $table->foreignId('document_type_id')->nullable()->constrained('component_option');
            $table->string('document_number')->nullable();
            $table->string('phone')->nullable();
            $table->string('IBAN')->nullable();
            $table->foreignId('user_title_id')->nullable()->constrained('component_option');
            $table->foreignId('address_id')->nullable()->constrained('address');
            $table->boolean('isActive')->default(1);
            $table->foreignId('country_id')->nullable()->constrained('country');
            $table->timestamp('disabled_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client');
    }
};
