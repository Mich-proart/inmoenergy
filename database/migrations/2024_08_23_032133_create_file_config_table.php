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
        Schema::create('file_config', function (Blueprint $table) {
            $table->id();
            $table->foreignId('component_option_id')->nullable()->constrained('component_option');
            $table->string('name');
            $table->boolean('is_available')->default(true);
            $table->boolean('is_required')->default(true);
        });

        $services = array(
            "luz" => "factura de luz",
            "agua" => "factura de agua",
            "gas" => "factura de gas",
            "fibra" => "factura de fibra / línea telefónica",
        );

        $generals = array(
            "DNI (Ambas caras)",
            "contrato de alquiler o contrato de compraventa",
            "autorización hacia InmoEnergy",
            "contrato del suministro"
        );

        foreach ($services as $key => $value) {
            $componentOption = DB::table('component_option')->where('name', $key)->first();
            if ($componentOption) {
                DB::table('file_config')->insert([
                    'name' => $value,
                    'component_option_id' => $componentOption->id
                ]);

            }
        }

        foreach ($generals as $key => $value) {
            DB::table('file_config')->insert([
                'name' => $value
            ]);
        }


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_config');
    }
};
