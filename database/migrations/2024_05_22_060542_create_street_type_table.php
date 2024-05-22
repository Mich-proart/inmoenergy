<?php

use App\Enums\StreetTypeEnum;
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

        foreach (StreetTypeEnum::cases() as $type) {
            StreetType::create(['name' => $type->value]);
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
