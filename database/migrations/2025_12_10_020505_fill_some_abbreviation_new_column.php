<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $second_data = array(
            "avenida"=> "Av.",
            "calle" => "C.",
            "paseo" => "P.",
            "pasaje"=> "Pje.",
            "rambla" => "Rbla.",
            "camino" => "Cno.",
            "carretera" => "Ctra.",
            "gran vía" => "Gran vía",
            "plaza" => "Pza.",
            "ronda" => "Rda.",
            "urbanización" => "Urb.",
        );

        foreach ($second_data as $key => $value) {
            DB::table('component_option')->where('name', $key)->update(['abbreviation' => $value]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
