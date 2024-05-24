<?php

use App\Domain\Enums\FormalityTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('formality_type', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        foreach (FormalityTypeEnum::cases() as $case) {
            DB::table('formality_type')->insert([
                'name' => $case->value
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formality_type');
    }
};
