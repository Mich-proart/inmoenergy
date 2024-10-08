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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('first_last_name')->nullable();
            $table->string('second_last_name')->nullable();
            $table->string('password');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('document_number')->nullable();
            $table->foreignId('adviser_assigned_id')->nullable()->constrained('users');
            $table->foreignId('responsible_id')->nullable()->constrained('users');
            $table->string('responsible_name')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('isActive')->default(1);
            $table->boolean('isWorker')->default(0);
            $table->timestamp('disabled_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
