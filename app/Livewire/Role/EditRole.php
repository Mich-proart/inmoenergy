<?php

namespace App\Livewire\Role;

use App\Exceptions\CustomException;
use App\Models\Program;
use App\Models\Section;
use Livewire\Component;
use DB;

class EditRole extends Component
{

    public $role;
    public $roleName;

    public $programIds = [];

    public $sections;
    public $rolePrograms;
    public $roleProgramsIds = [];


    public function __construct()
    {

    }

    public function mount($role)
    {

        $this->role = $role;
        $this->roleName = $role->name;

        $this->sections = Section::with(['programs', 'programs.permissions'])->get();

        $this->rolePrograms = Program::with('roles')
            ->whereHas('roles', function ($query) use ($role) {
                $query->where('roles.id', $role->id);
            })->get();


        foreach ($this->rolePrograms as $program) {
            $this->programIds[] = $program->id;
            array_push($this->roleProgramsIds, $program->id);
        }


    }


    public function validateRole()
    {
        $rule = [];
        $message = [];

        $rule['roleName'] = 'string|min:5';
        $message['roleName.string'] = 'El rol debe ser un texto';
        $message['roleName.min'] = 'El rol debe tener al menos 5 caracteres';

        if ($this->roleName == null || $this->roleName == '') {
            $rule['roleName'] = 'required|string|min:5';
            $message['roleName.required'] = 'El rol es requerido';
        }

        if ($this->roleName && $this->roleName != $this->role->name) {
            $rule['roleName'] = 'unique:roles,name';
            $message['roleName.unique'] = 'El rol ya existe';
        }

        $this->validate($rule, $message);
    }

    private function isAdded($id)
    {
        return in_array($id, $this->roleProgramsIds) ? false : true;
    }

    private function isRemoved($id)
    {
        return in_array($id, $this->programIds) ? false : true;
    }

    private function getProgram($id): Program
    {
        return Program::where('id', $id)->with('permissions')->first();
    }


    public function update()
    {

        $this->validateRole();

        DB::beginTransaction();


        try {

            if ($this->roleName != $this->role->name) {
                $this->role->update([
                    'name' => strtolower($this->roleName),
                ]);
            }

            $added = array_filter($this->programIds, [$this, 'isAdded']);
            $removed = array_filter($this->roleProgramsIds, [$this, 'isRemoved']);

            if (count($added) > 0) {
                foreach ($added as $id) {
                    $program = Program::where('id', $id)->with('permissions')->first();
                    if ($program) {
                        $program->roles()->attach($this->role);
                        $this->role->givePermissionTo($program->permissions);
                    }
                }

            }


            if (count($removed) > 0) {
                foreach ($removed as $id) {
                    $program = $this->getProgram($id);
                    if ($program) {
                        $program->roles()->detach($this->role);
                        $this->role->revokePermissionTo($program->permissions);
                    }
                }
            }


            DB::commit();
            return redirect()->route('admin.roles.index');

        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }


    }

    public function render()
    {
        return view('livewire.role.edit-role', ['sections' => $this->sections]);
    }
}
