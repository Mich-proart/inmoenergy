<?php

use App\Domain\Enums\UserTitleEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_title', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        foreach (UserTitleEnum::cases() as $case) {
            DB::table('user_title')->insert([
                'name' => $case->value
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_title');
    }
};
