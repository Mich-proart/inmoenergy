<?php

namespace App\Livewire\Role;

use App\Exceptions\CustomException;
use Livewire\Component;
use DB;
use Spatie\Permission\Models\Role;

class CreateRoleModal extends Component
{

    public $roleName;


    protected $rules = [
        'roleName' => 'required|string|unique:roles,name|min:5',
    ];

    protected $messages = [
        'roleName.required' => 'El rol es requerido',
        'roleName.unique' => 'El rol ya existe',
        'roleName.string' => 'El rol debe ser un texto',
        'roleName.min' => 'El rol debe tener al menos 5 caracteres',
    ];

    public function save()
    {
        $this->validate();

        DB::beginTransaction();

        try {
            Role::create([
                'name' => strtolower($this->roleName),
            ]);
            DB::commit();
            return redirect()->route('admin.roles.index');
        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }

    }

    public function render()
    {
        return view('livewire.role.create-role-modal');
    }
}
