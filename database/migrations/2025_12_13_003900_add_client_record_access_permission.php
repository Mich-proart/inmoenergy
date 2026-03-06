<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Insert the new permission
        $permissionId = \DB::table('permissions')->insertGetId([
            'name' => 'client.record.access',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Get the superadmin role
        $role = \DB::table('roles')->where('name', 'superadmin')->first();
        
        if ($role) {
            // Assign permission to superadmin role
            $exists = \DB::table('role_has_permissions')
                ->where('role_id', $role->id)
                ->where('permission_id', $permissionId)
                ->exists();
            
            if (!$exists) {
                \DB::table('role_has_permissions')->insert([
                    'role_id' => $role->id,
                    'permission_id' => $permissionId
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Get the permission
        $permission = \DB::table('permissions')
            ->where('name', 'client.record.access')
            ->first();
        
        if ($permission) {
            // Remove role assignments
            \DB::table('role_has_permissions')
                ->where('permission_id', $permission->id)
                ->delete();
            
            // Remove the permission
            \DB::table('permissions')
                ->where('id', $permission->id)
                ->delete();
        }
    }
};
