<?php

use App\Models\ComponentOption;
use App\Models\FileConfig;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $componetOption = ComponentOption::where('name', 'luz')->first();

        if ($componetOption) {
            $componetOption->update([
                'name' => 'electricidad',
            ]);
            $fileConfig = FileConfig::where('component_option_id', $componetOption->id)->first();

            if ($fileConfig) {
                $fileConfig->update([
                    'name' => 'factura de electricidad',
                ]);
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
};
