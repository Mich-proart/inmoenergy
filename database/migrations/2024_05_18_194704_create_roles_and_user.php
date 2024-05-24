<?php

use App\Domain\Enums\RolesEnum;
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
        foreach (RolesEnum::cases() as $role) {
            Role::create(['name' => $role->value]);
        }

        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmindev@dev.com',
            'password' => Hash::make('superadmindev'),
        ]);

        $superAdmin = Role::findByName(RolesEnum::SUPERADMIN->value);

        $user->assignRole($superAdmin);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
