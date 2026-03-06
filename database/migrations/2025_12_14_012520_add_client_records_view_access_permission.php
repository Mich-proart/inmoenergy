<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        // Create permission for client records view access
        Permission::firstOrCreate(['name' => 'client.records.view.access']);
        
        // Assign permission to superadmin role
        $superadminRole = Role::where('name', 'superadmin')->first();
        if ($superadminRole) {
            $superadminRole->givePermissionTo('client.records.view.access');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove permission
        $permission = Permission::where('name', 'client.records.view.access')->first();
        if ($permission) {
            $permission->delete();
        }
    }
};
