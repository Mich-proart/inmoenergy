<?php

namespace App\Livewire\Config;

use Livewire\Component;
use App\Exceptions\CustomException;
use App\Models\ComponentOption;
use DB;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class EditComponentOptions extends Component
{
    use WithPagination;

    public $component;
    public $name;
    public ComponentOption|null $option = null;

    public function mount($component)
    {
        $this->component = $component;
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

    #[On('changeAvailability')]
    public function changeAvailability($id)
    {
        DB::beginTransaction();
        $option = ComponentOption::find($id);
        try {

            if ($option !== null) {
                $option->update(['is_available' => !$option->is_available]);
                DB::commit();
            }
            DB::commit();
        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }

    }

    #[On('resetName')]
    public function resetName()
    {
        $this->name = null;
        $this->option = null;
    }

    public function render()
    {
        $options = ComponentOption::where('component_id', $this->component->id)->paginate(5);
        return view('livewire.config.edit-component-options', ['options' => $options]);
    }
}
