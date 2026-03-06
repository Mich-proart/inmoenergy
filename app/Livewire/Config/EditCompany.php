<?php

namespace App\Livewire\Config;

use Livewire\Component;
use App\Exceptions\CustomException;
use App\Models\Company;
use App\Models\Product;
use DB;

class EditCompany extends Component
{

    public $company_name;

    public $days_to_renew;
    public $company;
    public $product_name;


    public function mount($company)
    {
        $this->company = $company;
        $this->company_name = $company->name;
        $this->days_to_renew = $company->days_to_renew;
    }

    protected $rules = [
        'company_name' => 'required|string|min:3|max:255',
        'days_to_renew' => 'required|integer|between:1,365',

    ];

    protected $messages = [
        'company_name.required' => 'Debes introducir un nombre',
        'company_name.max' => 'El nombre no puede superar los 255 caracteres',
        'days_to_renew.required' => 'Debes introducir un día de renovación',
        'days_to_renew.integer' => 'El día de renovación debe ser un número',
        'days_to_renew.between' => 'El día de renovación debe estar entre 1 y 365 días',
    ];

    public function update()
    {
        $this->validate();

        DB::beginTransaction();

        try {

            // Only check for duplicate names if the name has changed
            if ($this->company_name !== $this->company->name) {
                $found = Company::where('name', $this->company_name)->first();
                if ($found) {
                    DB::rollBack();
                    session()->flash('error', 'Ya existe una comercializadora con este nombre');
                    return;
                }
            }

            $updates = [
                'name' => $this->company_name,
                'days_to_renew' => $this->days_to_renew
            ];

            Company::firstWhere('id', $this->company->id)->update($updates);
            DB::commit();
            session()->flash('success', 'Comercializadora actualizada exitosamente');
            return redirect()->route('admin.company.manager');
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Error al actualizar la comercializadora: ' . $th->getMessage());
            return;
        }
    }

    public function save()
    {
        $this->validate(
            [
                'product_name' => 'required|string|min:3|max:255|unique:product,name,'
            ],
            [
                'product_name.unique' => 'El producto ya existe',
                'product_name.required' => 'El campo es requerido',
                'product_name.min' => 'El campo debe tener al menos 3 caracteres',
            ]
        );

        DB::beginTransaction();

        try {
            $found = Product::where('name', $this->product_name)->first();
            if ($found) {
                DB::rollBack();
                session()->flash('error', 'Ya existe un producto con este nombre');
                return;
            }

            Product::create([
                'name' => $this->product_name,
                'company_id' => $this->company->id
            ]);
            DB::commit();
            session()->flash('success', 'Producto creado exitosamente');
            return redirect()->route('admin.company.manager.details', $this->company->id);
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Error al crear el producto: ' . $th->getMessage());
            return;
        }


    }


    public function render()
    {
        return view('livewire.config.edit-company');
    }
}
