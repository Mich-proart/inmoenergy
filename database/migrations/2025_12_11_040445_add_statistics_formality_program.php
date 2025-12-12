<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\Program;
use App\Models\Section;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
                $path = base_path('formality.statics.json');

        if (!File::exists($path)) {
            throw new \Exception("File not found: {$path}");
        }

        $sections = File::json($path);

        Log::info('=== Statistics Formality JSON Parsed ===', [
            'new program | statistics formalities' => $sections
        ]);

        foreach ($sections as $sectionData) {
            $data_section = Section::where('name', $sectionData['name'])->first();
            $program_list = [];
            foreach ($sectionData['programs'] as $program) {
                $created = Program::create([
                    'name' => $program['name'],
                    'section_id' => $data_section->id,
                    'image' => $program['image'],
                    'route' => $program['route'],
                    'description' => $program['description'],
                    'placed_in' => $program['placed_in'],
                ]);

                $permmission = Permission::firstOrCreate(['name' => $program['permission']]);

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
        //
    }
};
