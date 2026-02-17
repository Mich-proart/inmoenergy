<?php

use App\Models\Program;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $files = [
            'client_record.json',
            'client_records_view.json'
        ];

        foreach ($files as $filename) {
            if (!File::exists(base_path($filename))) {
                continue;
            }

            $sections = File::json(base_path($filename));

            foreach ($sections as $section) {
                foreach ($section['programs'] as $programData) {
                    $program = Program::where('name', $programData['name'])->first();

                    if (!$program) {
                        continue;
                    }

                    // 1. Ensure permission exists
                    $permissionName = $programData['permission'];
                    $permission = Permission::firstOrCreate(['name' => $permissionName]);

                    // 2. Link Program <-> Permission (model_has_permissions)
                    $program->syncPermissions($permission);

                    // 3. Link Role <-> Permission (role_has_permissions)
                    if (isset($programData['roles']) && is_array($programData['roles'])) {
                        foreach ($programData['roles'] as $roleName) {
                            $role = Role::where('name', $roleName)->first();
                            if ($role) {
                                $role->givePermissionTo($permission);
                            }
                        }
                    }
                }
            }
        }
        
        // Clear permission cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No strict reverse action as this is data fix
    }
};
