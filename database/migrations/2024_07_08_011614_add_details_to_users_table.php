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
            $table->string('first_last_name')->nullable();
            $table->string('second_last_name')->nullable();
            $table->string('document_number')->nullable();
            $table->foreignId('document_type_id')->nullable()->constrained('document_type');
            $table->string('phone')->nullable();
            $table->foreignId('client_type_id')->nullable()->constrained('client_type');
            $table->foreignId('adviser_assigned_id')->nullable()->constrained('users');
            $table->foreignId('responsible_id')->nullable()->constrained('users');
            $table->foreignId('user_title_id')->nullable()->constrained('user_title');
            $table->string('IBAN')->nullable();
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
