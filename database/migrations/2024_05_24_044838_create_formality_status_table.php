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
        Schema::create('formality_status', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        $mainValues = [
            "pendiente tramitar",
            "asignado",
            "revisando documentación",
            "en curso",
            "tramitado",
            "en vigor",
            "KO",
            "incidencia"
        ];

        foreach ($mainValues as $case) {
            DB::table('formality_status')->insert([
                'name' => $case
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formality_status');
    }
};
