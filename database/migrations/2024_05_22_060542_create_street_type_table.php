<?php

use App\Models\StreetType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('street_type', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        $mainValues = ["avenida", "calle", "pasaje", "paseo"];

        foreach ($mainValues as $type) {
            StreetType::create(['name' => $type]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('street_type');
    }
};
