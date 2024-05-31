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
        Schema::create('access_rate', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        $mainValues = ["2.0", "3.0", "RL1", "RL2", "RL3"];

        foreach ($mainValues as $case) {
            DB::table('access_rate')->insert([
                'name' => $case
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('access_rate');
    }
};
