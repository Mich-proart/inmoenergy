<?php

use App\Models\User;
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

        $mainValues = [
            "superadmin",
            "comercial",
            "inmobiliaria"
        ];

        $toPermissions = array(
            "formality.create" => array(
                'guard_name' => 'crear nuevos trámites',
                'roles' => ['superadmin', 'inmobiliaria']
            ),
            "formality.inprogress.get" => array(
                'guard_name' => 'ver trámites en curso',
                'roles' => ['superadmin', 'inmobiliaria']
            ),
            "formality.closed.get" => array(
                'guard_name' => 'ver trámites cerrados',
                'roles' => ['superadmin', 'inmobiliaria']
            ),
            "formality.assigned.get" => array(
                'guard_name' => 'ver trámites asignados',
                'roles' => ['superadmin', 'comercial']
            ),
            "formality.completed.get" => array(
                'guard_name' => 'vertrámites realizados',
                'roles' => ['superadmin', 'comercial']
            ),
            "formality.pending.get" => array(
                'guard_name' => 'ver altas pendientes fecha de activación',
                'roles' => ['superadmin', 'comercial']
            ),
            "formality.assignment.get" => array(
                'guard_name' => 'listar asignación de trámites',
                'roles' => ['superadmin']
            ),
            "formality.totalInProgress.get" => array(
                'guard_name' => 'ver trámites en curso totales',
                'roles' => ['superadmin']
            ),
            "documents.authorization.get" => array(
                'guard_name' => 'ver documentos de autorización',
                'roles' => ['superadmin', 'inmobiliaria']
            ),
            "documents.change.get" => array(
                'guard_name' => 'ver documentos para cambio de titular',
                'roles' => ['superadmin', 'inmobiliaria']
            ),
            "manage.user.get" => array(
                'guard_name' => 'ver gestión de usuarios',
                'roles' => ['superadmin']
            ),
            "manage.client.get" => array(
                'guard_name' => 'ver gestión de clientes',
                'roles' => ['superadmin']
            ),
            "manage.company.get" => array(
                'guard_name' => 'ver gestión de comercializadoras',
                'roles' => ['superadmin']
            ),
            "manage.product.get" => array(
                'guard_name' => 'ver gestión de productos',
                'roles' => ['superadmin']
            ),
            "config.dropdown.get" => array(
                'guard_name' => 'ver desplegables',
                'roles' => ['superadmin']
            ),
            "manage.role.get" => array(
                'guard_name' => 'ver gestión de roles',
                'roles' => ['superadmin']
            ),
        );

        foreach ($mainValues as $role) {
            Role::create(['name' => $role]);
        }

        foreach ($toPermissions as $permission => $values) {
            $permission = Permission::create(['name' => $permission]);
            foreach ($values['roles'] as $role) {
                $permission->assignRole(Role::findByName($role));
            }
        }

        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmindev@dev.com',
            'password' => Hash::make('superadmindev'),
        ]);

        $superAdmin = Role::findByName('superadmin');

        $user->assignRole($superAdmin);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
