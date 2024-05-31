<?php

use App\Models\User;
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

        $mainValues = [
            "superadmin",
            "comercial",
            "inmobiliaria"
        ];

        foreach ($mainValues as $role) {
            Role::create(['name' => $role]);
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
