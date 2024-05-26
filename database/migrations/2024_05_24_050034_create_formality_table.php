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
        Schema::create('formality', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_client_id')->constrained('users');
            $table->foreignId('user_issuer_id')->constrained('users');
            $table->foreignId('user_Assigned_id')->nullable()->constrained('users');
            $table->text('observation')->nullable();
            $table->boolean('canIssuerEdit')->default(false);
            $table->boolean('isCritical')->default(false);
            $table->boolean('isRenewable')->default(false);
            $table->timestamp('assignment_date')->nullable();
            $table->timestamp('completion_date')->nullable();
            $table->timestamp('renewal_date')->nullable();
            $table->timestamp('activation_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('CUPS')->nullable();
            $table->text('internal_observation')->nullable();
            $table->integer('annual_consupmption')->nullable();
            $table->boolean('isClientAddress')->default(false);
            $table->foreignId('address_id')->nullable()->constrained('address');
            $table->foreignId('formality_type_id')->constrained('formality_type');
            $table->foreignId('formality_status_id')->constrained('formality_status');
            $table->foreignId('access_rate_id')->nullable()->constrained('access_rate');
            $table->foreignId('service_id')->constrained('service');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formality');
    }
};
