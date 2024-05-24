<?php

use App\Domain\Enums\ClientTypeEnum;
use App\Domain\Enums\DocumentTypeEnum;
use App\Domain\Enums\HousingTypeEnum;
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
        Schema::create('user_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('first_last_name')->nullable();
            $table->string('second_last_name')->nullable();
            $table->string('document_number')->nullable();
            $table->enum('document_type', [DocumentTypeEnum::DNI->value, DocumentTypeEnum::PASSPORT->value])->nullable();
            $table->string('phone')->nullable();
            $table->enum('client_type', [ClientTypeEnum::PERSON->value, ClientTypeEnum::BUSINESS->value])->nullable();
            $table->foreignId('address_id')->nullable()->constrained('address');
            $table->foreignId('adviser_assigned_id')->nullable()->constrained('users');
            $table->foreignId('responsible_id')->nullable()->constrained('users');
            $table->enum('user_title', [UserTitleEnum::Sr->value, UserTitleEnum::Sra->value])->nullable();
            $table->enum('housing_type', [HousingTypeEnum::local->value, HousingTypeEnum::living_place->value])->nullable();
            $table->string('IBAN')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_detail');
    }
};
