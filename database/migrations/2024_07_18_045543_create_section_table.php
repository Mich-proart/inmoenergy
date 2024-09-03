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
        Schema::create('section', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        /*
        $mainValues = [
            "trámites clientes",
            "trámites y tickets",
            "Herramientas",
            "documentación",
            "configuración"
        ];

        foreach ($mainValues as $case) {
            DB::table('section')->insert([
                'name' => $case
            ]);
        }
            */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section');
    }
};
