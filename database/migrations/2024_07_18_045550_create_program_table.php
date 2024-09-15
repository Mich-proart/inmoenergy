<?php

use App\Models\Program;
use App\Models\Section;
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
        Schema::create('program', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('section_id')->nullable()->constrained('section');
            $table->string('image')->nullable();
            $table->string('route')->nullable();
            $table->string('placed_in')->nullable();
            $table->string('description')->nullable();
        });

        Schema::create('program_role', function (Blueprint $table) {
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('role_id');
            $table->foreign('program_id')->references('id')->on('program');
            $table->foreign('role_id')->references('id')->on('roles');
        });

        $sections = File::json(base_path('section.json'));

        foreach ($sections as $section) {
            $data_section = Section::create(['name' => $section['name']]);
            $program_list = [];
            foreach ($section['programs'] as $program) {
                $created = Program::create([
                    'name' => $program['name'],
                    'route' => $program['route'],
                    'image' => $program['image'],
                    'placed_in' => $program['placed_in'],
                    'description' => $program['description']
                ]);

                $permmission = Permission::where('name', $program['permission'])->first();
                if ($permmission) {
                    $created->syncPermissions($permmission);
                }
                $program_list[] = $created;

                $roles_list = [];
                foreach ($program['roles'] as $role) {
                    $roles_list[] = Role::where('name', $role)->first();
                }
                $created->roles()->saveMany($roles_list);
            }

            $data_section->programs()->saveMany($program_list);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program');
    }
};
