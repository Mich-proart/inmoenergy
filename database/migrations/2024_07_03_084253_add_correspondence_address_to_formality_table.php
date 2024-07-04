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
            $table->foreignId('correspondence_address_id')->nullable()->constrained('address');
            $table->boolean('isSameCorrespondenceAddress')->default(true);
            $table->dropColumn('isClientAddress');
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
