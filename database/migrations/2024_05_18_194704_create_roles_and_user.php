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
        $roles = File::json(base_path('roles.json'));

        foreach ($roles as $role) {
            $createdRole = Role::create($role);
            $permissions = $role['permissions'];

            $createdPermissions = array();

            foreach ($permissions as $permission) {
                $createdPermissions[] = Permission::createOrFirst(['name' => $permission]);
            }

            $createdRole->syncPermissions($createdPermissions);
        }

        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmindev@dev.com',
            'password' => Hash::make('superadmindev'),
        ]);

        $inmoenergy = User::create([
            'name' => 'inmoenergy',
            'email' => 'inmobiliarias@inmoenergy.es',
            'password' => Hash::make('f&v!59r2P@5&v6J'),
        ]);

        $superAdmin = Role::findByName('superadmin');

        $user->assignRole($superAdmin);
        $inmoenergy->assignRole($superAdmin);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
