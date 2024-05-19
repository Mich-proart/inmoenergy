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
            $table->string('first_name');
            $table->string('last_name');
            $table->string('second_last_name')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('document_number')->unique();
            $table->string('bank_account_number')->unique();
            $table->foreignId('address_id')->constrained('address');
            $table->foreignId('document_type_id')->constrained('document_type');
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
