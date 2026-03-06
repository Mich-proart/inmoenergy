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
        // Get the superadmin role
        $role = \DB::table('roles')->where('name', 'superadmin')->first();
        
        if (!$role) {
            throw new \Exception('Superadmin role not found');
        }
        
        // Define the permissions to relate
        $permissionNames = [
            'tool.statistics.formality.access',
            'formality.commission.manager.access'
        ];
        
        // Get the permissions
        $permissions = \DB::table('permissions')
            ->whereIn('name', $permissionNames)
            ->get();
        
        // Insert the relationships if they don't exist
        foreach ($permissions as $permission) {
            $exists = \DB::table('role_has_permissions')
                ->where('role_id', $role->id)
                ->where('permission_id', $permission->id)
                ->exists();
            
            if (!$exists) {
                \DB::table('role_has_permissions')->insert([
                    'role_id' => $role->id,
                    'permission_id' => $permission->id
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Get the superadmin role
        $role = \DB::table('roles')->where('name', 'superadmin')->first();
        
        if (!$role) {
            return;
        }
        
        // Define the permissions to remove
        $permissionNames = [
            'tool.statistics.formality.access',
            'formality.commission.manager.access'
        ];
        
        // Get the permissions
        $permissions = \DB::table('permissions')
            ->whereIn('name', $permissionNames)
            ->get();
        
        // Remove the relationships
        foreach ($permissions as $permission) {
            \DB::table('role_has_permissions')
                ->where('role_id', $role->id)
                ->where('permission_id', $permission->id)
                ->delete();
        }
    }
};
