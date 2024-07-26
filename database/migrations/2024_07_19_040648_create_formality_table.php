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
            $table->text('issuer_observation')->nullable();
            $table->boolean('isCritical')->default(false);
            $table->boolean('canClientEdit')->default(false);
            $table->boolean('isRenewable')->default(false);
            $table->timestamp('assignment_date')->nullable();
            $table->timestamp('completion_date')->nullable();
            $table->timestamp('renewal_date')->nullable();
            $table->timestamp('activation_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('CUPS')->nullable();
            $table->text('internal_observation')->nullable();
            $table->integer('annual_consumption')->nullable();
            $table->decimal('commission', 10, 2)->nullable();
            $table->decimal('potency', 10, 2)->nullable();
            $table->foreignId('address_id')->nullable()->constrained('address');
            $table->foreignId('correspondence_address_id')->nullable()->constrained('address');
            $table->boolean('isSameCorrespondenceAddress')->default(true);
            $table->foreignId('formality_type_id')->constrained('component_option');
            $table->foreignId('status_id')->constrained('status');
            $table->foreignId('access_rate_id')->nullable()->constrained('component_option');
            $table->foreignId('service_id')->constrained('component_option');
            $table->foreignId('product_id')->nullable()->constrained('product');
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
