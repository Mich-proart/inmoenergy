<?php

use App\Models\Program;
use App\Models\User;
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
        $program = Program::where('name', 'datos trámites inmoenergy')->first();
        $user = User::where('name', 'inmoenergy')->first();

        if ($program) {
            $program->update(['name' => 'datos trámites lenders consulting']);
        }

        if ($user) {
            $user->update(['name' => 'lenders consulting']);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
