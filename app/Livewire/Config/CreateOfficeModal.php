<?php

namespace App\Livewire\Config;

use Livewire\Component;
use App\Exceptions\CustomException;
use App\Models\BusinessGroup;
use App\Models\Office;
use DB;

class CreateOfficeModal extends Component
{

    public $name;

    public Office|null $office = null;

    public BusinessGroup|null $business = null;

    public function mount($business)
    {
        $this->business = $business;
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

            if ($this->office !== null) {
                $this->office->update(['name' => strtolower($this->name)]);
                DB::commit();
                return redirect()->route('admin.config.offices', $this->business->id);
            }

            Office::create([
                'name' => strtolower($this->name),
                'business_group_id' => $this->business->id
            ]);

            DB::commit();
            return redirect()->route('admin.config.offices', $this->business->id);
        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }

    }

    public function setOffice(int $id)
    {
        $office = Office::find($id);

        if ($office) {
            $this->office = $office;
            $this->name = $this->office->name;
        }

    }


    public function resetName()
    {
        $this->name = null;
        $this->office = null;
    }


    public function render()
    {
        return view('livewire.config.create-office-modal');
    }
}
