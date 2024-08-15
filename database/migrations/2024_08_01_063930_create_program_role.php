<?php

use App\Models\Program;
use App\Models\Section;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('program_role', function (Blueprint $table) {
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('role_id');
            $table->foreign('program_id')->references('id')->on('program')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });


        $values = array(
            "nuevo trámite" => array(
                'roles' => ['superadmin', 'inmobiliaria']
            ),
            "trámites en curso" => array(
                'roles' => ['superadmin', 'inmobiliaria']
            ),
            "trámites cerrados" => array(
                'roles' => ['superadmin', 'inmobiliaria']
            ),
            "trámites asignados" => array(
                'roles' => ['superadmin', 'comercial']
            ),
            "trámites realizados" => array(
                'roles' => ['superadmin', 'comercial']
            ),
            "altas pendientes fecha de activación" => array(
                'roles' => ['superadmin', 'comercial']
            ),
            "asignación de trámites" => array(
                'roles' => ['superadmin']
            ),
            "trámites en curso totales" => array(
                'roles' => ['superadmin']
            ),
            "autorización" => array(
                'roles' => ['inmobiliaria']
            ),
            "documentos cambio" => array(
                'roles' => ['inmobiliaria']
            ),
            "gestión de usuarios" => array(
                'roles' => ['superadmin']
            ),
            "gestión de clientes" => array(
                'roles' => ['superadmin']
            ),
            "gestión de comercializadoras" => array(
                'roles' => ['superadmin']
            ),
            "gestión de productos" => array(
                'roles' => ['superadmin']
            ),
            "desplegables" => array(
                'roles' => ['superadmin']
            ),
        );



        foreach ($values as $key => $value) {
            $program = Program::where('name', $key)->first();
            if ($program) {
                foreach ($value['roles'] as $role) {
                    $role = Role::findByName($role);
                    if ($role) {
                        $program->roles()->attach($role->id);
                    }
                }
            }
        }

        $data = array(
            'placed_in' => 5,
            'image' => 'roles_manager.png',
            'roles' => ['superadmin'],
            'route' => 'admin.roles.index',
            'name' => 'gestión de roles'
        );

        Program::where('name', 'desplegables')->update(['placed_in' => 6]);

        $section = Section::where('name', 'configuración')->first();
        if ($section) {
            $role = Role::findByName($data['roles'][0]);
            $program = Program::create([
                'name' => $data['name'],
                'section_id' => $section->id,
                'image' => $data['image'],
                'placed_in' => $data['placed_in'],
                'route' => $data['route']
            ]);

            $program->roles()->attach($role->id);

        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_role');
    }
};
