<?php

use App\Models\Country;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('country', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_spanish');
            $table->string('nom');
            $table->string('iso2');
            $table->string('iso3');
            $table->string('phone_code');

        });

        $countries = File::json(base_path('countries_code.json'));

        foreach ($countries as $country) {
            Country::create([
                'name' => $country['name'],
                'name_spanish' => $country['nombre'],
                'nom' => $country['nom'],
                'iso2' => $country['iso2'],
                'iso3' => $country['iso3'],
                'phone_code' => $country['phone_code'],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('country');
    }
};
