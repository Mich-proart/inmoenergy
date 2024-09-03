<?php

use App\Models\Program;
use App\Models\Section;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
            $table->string('placed_in')->nullable();
            $table->string('description')->nullable();
        });

        Schema::create('program_role', function (Blueprint $table) {
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('role_id');
            $table->foreign('program_id')->references('id')->on('program');
            $table->foreign('role_id')->references('id')->on('roles');
        });

        $sections = File::json(base_path('section.json'));

        foreach ($sections as $section) {
            $data_section = Section::create(['name' => $section['name']]);
            $program_list = [];
            foreach ($section['programs'] as $program) {
                $created = Program::create([
                    'name' => $program['name'],
                    'route' => $program['route'],
                    'image' => $program['image'],
                    'placed_in' => $program['placed_in'],
                    'description' => $program['description']
                ]);

                $program_list[] = $created;

                $roles_list = [];
                foreach ($program['roles'] as $role) {
                    $roles_list[] = Role::where('name', $role)->first();
                }
                $created->roles()->saveMany($roles_list);
            }

            $data_section->programs()->saveMany($program_list);
        }

        /*
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
                    */

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program');
    }
};
