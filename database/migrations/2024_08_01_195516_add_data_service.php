<?php

use App\Models\Component;
use App\Models\ComponentOption;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $component = Component::where('name', 'suministro')->first();

        if ($component) {
            ComponentOption::create([
                'name' => 'fibra',
                'component_id' => $component->id
            ]);

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
