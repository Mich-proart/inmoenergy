<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('file_config', function (Blueprint $table) {
            $table->string('tipo_carpeta')->nullable()->after('is_required');
        });

        // Seed folder classifications as requested in page 6 of the PDF
        // Client documents: DocumentacionCliente
        DB::table('file_config')
            ->whereIn('id', [5, 6, 7, 9, 10])
            ->update(['tipo_carpeta' => 'DocumentacionCliente']);

        // Formality documents: DocumentacionTramite
        DB::table('file_config')
            ->whereIn('id', [1, 2, 3, 4, 8])
            ->update(['tipo_carpeta' => 'DocumentacionTramite']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('file_config', function (Blueprint $table) {
            $table->dropColumn('tipo_carpeta');
        });
    }
};
