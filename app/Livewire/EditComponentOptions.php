<?php

namespace App\Livewire;

use App\Exceptions\CustomException;
use App\Models\ComponentOption;
use Livewire\Component;
use DB;

class EditComponentOptions extends Component
{

    public $component;
    public $name;
    public ComponentOption|null $option = null;

    public function mount($component)
    {
        $this->component = $component;
    }

    public function render()
    {
        return view('livewire.edit-component-options');
    }

    public function editoption(int $id)
    {
        $this->option = ComponentOption::find($id);
        $this->name = $this->option->name;
    }

    protected $rules = [
        'name' => 'required|max:255|unique:component_option,name'
    ];

    protected $messages = [
        'name.required' => 'El nombre es requerido',
        'name.max' => 'El nombre es demasiado extenso',
        'name.unique' => 'El nombre ya existe',
    ];

    public function save()
    {
        $this->validate();

        DB::beginTransaction();

        try {

            if ($this->option !== null) {
                $this->option->update(['name' => strtolower($this->name)]);
                DB::commit();
                return redirect()->route('admin.component.details', $this->component->id);
            }

            ComponentOption::create([
                'name' => strtolower($this->name),
                'component_id' => $this->component->id
            ]);

            DB::commit();
            return redirect()->route('admin.component.details', $this->component->id);
        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }

    }

    public function resetName()
    {
        $this->name = null;
        $this->option = null;
    }
}
