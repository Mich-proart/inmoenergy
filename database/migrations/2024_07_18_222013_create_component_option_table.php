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
        Schema::create('component_option', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('component_id')->nullable()->constrained('component');
            $table->boolean('is_available')->default(true);
            $table->string('description')->nullable();
        });

        $data = array(
            "tipo de trámite" => array(
                "alias" => "formality_type",
                "data" => array(
                    "alta nueva",
                    "cambio de titular"
                )
            ),
            "suministro" => array(
                "alias" => "service",
                "data" => array(
                    "luz",
                    "agua",
                    "gas"
                )
            ),
            "tipo de cliente" => array(
                "alias" => "client_type",
                "data" => array(
                    "persona física",
                    "persona jurídica"
                )
            ),
            "título de cliente" => array(
                "alias" => "user_title",
                "data" => array(
                    "Sr.",
                    "Sra."
                )
            ),
            "tipo de documento cliente" => array(
                "alias" => "document_type",
                "data" => array(
                    "DNI",
                    "pasaporte"
                )
            ),
            "tipo de calle" => array(
                "alias" => "street_type",
                "data" => array(
                    "avenida",
                    "calle",
                    "pasaje",
                    "paseo"
                )
            ),
            "tarifa de acceso" => array(
                "alias" => "access_rate",
                "data" => array(
                    "2.0",
                    "3.0",
                    "RL1",
                    "RL2",
                    "RL3"
                )
            ),
            "tipo de vivienda" => array(
                "alias" => "housing_type",
                "data" => array(
                    "vivienda",
                    "local"
                )
            ),
            "tipo de incetivo" => array(
                "alias" => "incentive_type",
                "data" => array(
                    'consultas',
                    'facturar'
                )
            )
        );

        foreach ($data as $component => $values) {
            $data_component = DB::table('component')->where('alias', $values['alias'])->first();
            foreach ($values['data'] as $name) {
                DB::table('component_option')->insert([
                    'name' => $name,
                    'component_id' => $data_component->id
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('component_option');
    }
};