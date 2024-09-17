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
        Schema::create('ticket', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_issuer_id')->constrained('users');
            $table->foreignId('user_assigned_id')->nullable()->constrained('users');
            $table->foreignId('formality_id')->nullable()->constrained('formality');
            $table->foreignId('ticket_type_id')->constrained('component_option');
            $table->foreignId('status_id')->constrained('status');
            $table->string('ticket_title');
            $table->text('ticket_description');
            $table->timestamp('resolution_date')->nullable();
            $table->timestamp('assignment_date')->nullable();
            $table->boolean('isResolved')->default(false);
            $table->text('resolution_comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket');
    }
};
