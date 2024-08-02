<?php

use App\Models\Program;
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
        Schema::table('program', function (Blueprint $table) {
            $table->string('placed_in')->nullable();
        });

        Program::where('name', 'desplegables')->update(['route' => 'admin.config.component']);
        Program::where('name', 'consultas totales')->update(['name' => 'trámites en curso totales']);
        Program::where('name', 'documentos para realizar cambio de titular')->update(['name' => 'documentos cambio']);


        $values = array(
            "nuevo trámite" => array(
                'placed_in' => 1,
                'image' => 'create_formality.png',
                'roles' => ['superadmin', 'comercial', 'inmobiliaria']
            ),
            "trámites en curso" => array(
                'placed_in' => 2,
                'image' => 'in_progress_formality.png',
                'roles' => ['superadmin', 'comercial', 'inmobiliaria']
            ),
            "trámites cerrados" => array(
                'placed_in' => 3,
                'image' => 'closed_formality.png',
                'roles' => ['superadmin', 'comercial', 'inmobiliaria']
            ),
            "trámites asignados" => array(
                'placed_in' => 1,
                'image' => 'asigned_formality.png',
                'roles' => ['superadmin', 'comercial']
            ),
            "trámites realizados" => array(
                'placed_in' => 3,
                'image' => 'closed_formality.png',
                'roles' => ['superadmin', 'comercial']
            ),
            "altas pendientes" => array(
                'placed_in' => 5,
                'image' => 'pending_formality.png',
                'roles' => ['superadmin', 'comercial']
            ),
            "asignación de trámites" => array(
                'placed_in' => 6,
                'image' => 'formality_assignment.png',
                'roles' => ['superadmin', 'comercial', 'inmobiliaria']
            ),
            "trámites en curso totales" => array(
                'placed_in' => 9,
                'image' => 'total_inprogrss_formality.png',
                'roles' => ['superadmin', 'comercial', 'inmobiliaria']
            ),
            "autorización" => array(
                'placed_in' => 1,
                'image' => 'authentication_docs.png',
                'roles' => ['inmobiliaria']
            ),
            "documentos cambio" => array(
                'placed_in' => 2,
                'image' => 'change_owner_docs.png',
                'roles' => ['inmobiliaria']
            ),
            "gestión de usuarios" => array(
                'placed_in' => 1,
                'image' => 'users_manager.png',
                'roles' => ['superadmin']
            ),
            "gestión de clientes" => array(
                'placed_in' => 2,
                'image' => 'client_manager.png',
                'roles' => ['superadmin']
            ),
            "gestión de comercializadoras" => array(
                'placed_in' => 3,
                'image' => 'company_manager.png',
                'roles' => ['superadmin']
            ),
            "gestión de productos" => array(
                'placed_in' => 4,
                'image' => 'product_manager.png',
                'roles' => ['superadmin']
            ),
            "desplegables" => array(
                'placed_in' => 5,
                'image' => 'dropdowns.png',
                'roles' => ['superadmin']
            ),
        );


        foreach ($values as $key => $value) {
            $program = Program::where('name', $key)->first();
            if ($program) {
                $program->update([
                    'placed_in' => $value['placed_in'],
                    'image' => $value['image']
                ]);
            }

        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('program', function (Blueprint $table) {
            //
        });
    }
};
