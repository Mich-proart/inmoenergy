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
        Schema::create('program', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('section_id')->nullable()->constrained('section');
            $table->string('image')->nullable();
            $table->string('route')->nullable();
            $table->string('description')->nullable();
        });

        $maimValues = array(
            "trámites clientes" => array(
                "nuevo trámite" => "admin.formality.create",
                "trámites en curso" => "admin.formality.inprogress",
                "trámites cerrados" => "admin.formality.closed"
            ),
            "trámites y tickets" => array(
                "trámites asignados" => "admin.formality.assigned",
                "trámites realizados" => "admin.formality.completed",
                "altas pendientes fecha de activación" => "admin.formality.pending"
            ),
            "herramientas" => array(
                "asignación de trámites" => "admin.formality.assignment",
                "consultas totales" => "admin.formality.totalInProgress"
            ),
            "documentación" => array(
                "autorización" => "admin.document.authorization",
                "documentos para cambio de titular" => "admin.document.changeTitle",
            ),
            "configuración" => array(
                "gestión de usuarios" => "admin.users",
                "gestión de clientes" => "admin.clients",
                "gestión de comercializadoras" => "admin.company.manager",
                "gestión de productos" => "admin.product.manager",
                "desplegables" => "admin.dropdowns",
            )
        );

        foreach ($maimValues as $section => $values) {
            foreach ($values as $name => $route) {
                $data_section = DB::table('section')->where('name', $section)->first();
                DB::table('program')->insert([
                    'name' => $name,
                    'section_id' => $data_section->id,
                    'route' => $route
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program');
    }
};
