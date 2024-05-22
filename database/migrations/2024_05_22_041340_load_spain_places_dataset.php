<?php

use App\Models\Location;
use App\Models\Province;
use App\Models\Region;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $places = Storage::json('public/spain_places_dataset.json');

        foreach ($places as $place) {
            $region = $this->createRegion($place['label']);

            foreach ($place['provinces'] as $province) {
                $province_created = $this->createProvince($province['label'], $region->id);
                foreach ($province['towns'] as $location) {
                    $this->createLocation($location['label'], $province_created->id);
                }
            }
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }

    /**
     * Create a new region.
     *
     * @param string $name
     * @return Region
     */
    private function createRegion(string $name): Region
    {
        return Region::create([
            'name' => $name,
        ]);
    }

    /**
     * Create a new province.
     *
     * @param string $name
     * @param int $regionId
     * @return Province
     */
    private function createProvince(string $name, int $regionId): Province
    {
        return Province::create([
            'name' => $name,
            'region_id' => $regionId,
        ]);
    }

    /**
     * Create a new location.
     *
     * @param string $name
     * @param int $provinceId
     * @return Location
     */
    private function createLocation(string $name, int $provinceId): Location
    {
        return Location::create([
            'name' => $name,
            'province_id' => $provinceId,
        ]);
    }

};
