<?php

namespace App\Livewire;

use App\Exceptions\CustomException;
use App\Models\BusinessGroup;
use Livewire\Component;
use DB;

class CreateBusinessGroupModal extends Component
{

    public $name;

    public BusinessGroup|null $businessGroup = null;

    public function render()
    {
        return view('livewire.create-business-group-modal');
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|max:255|unique:business_group,name',
        ], [
            'name.required' => 'El nombre es requerido',
            'name.max' => 'El nombre es demasiado extenso',
            'name.unique' => 'El nombre ya existe',
        ]);

        DB::beginTransaction();

        try {

            if ($this->businessGroup !== null) {
                $this->businessGroup->update(['name' => strtolower($this->name)]);
                DB::commit();
                return redirect()->route('admin.config.businessGroup');
            }

            BusinessGroup::create([
                'name' => strtolower($this->name),
            ]);

            DB::commit();
            return redirect()->route('admin.config.businessGroup');
        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }

    }

    public function setBusiness($id)
    {
        $this->businessGroup = BusinessGroup::find($id);
        $this->name = $this->businessGroup->name;
    }

    public function resetName()
    {
        $this->name = null;
        $this->businessGroup = null;
    }
}
