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
        Schema::create('component', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('alias')->nullable();
            $table->foreignId('program_id')->nullable()->constrained('program');
            $table->boolean('is_available')->default(true);
            $table->string('description')->nullable();
        });
        /*
        $maimValues = array(
            "desplegables" => array(
                "tipo de trámite" => "formality_type",
                "suministro" => "service",
                "tipo de cliente" => "client_type",
                "título de cliente" => "user_title",
                "tipo de documento cliente" => "document_type",
                "tipo de calle" => "street_type",
                "tarifa de acceso" => "access_rate",
                "tipo de vivienda" => "housing_type",
                "tipo de incetivo" => "incentive_type",
                "tipo de ticket" => "ticket_type"
            )
        );

        foreach ($maimValues as $program => $values) {
            $data_program = DB::table('program')->where('name', $program)->first();
            foreach ($values as $name => $alias) {
                DB::table('component')->insert([
                    'name' => $name,
                    'alias' => $alias,
                    'program_id' => $data_program->id
                ]);
            }
        }
            */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('component');
    }
};
