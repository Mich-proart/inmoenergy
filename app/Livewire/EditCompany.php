<?php

namespace App\Livewire;

use App\Exceptions\CustomException;
use App\Models\Company;
use App\Models\Product;
use Livewire\Component;
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

    public function render()
    {
        return view('livewire.edit-company');
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

            $updates = [
                'name' => strtolower($this->company_name),
                'days_to_renew' => $this->days_to_renew
            ];

            Company::firstWhere('id', $this->company->id)->update($updates);
            DB::commit();
            return redirect()->route('admin.company.manager');
        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
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
            if ($found)
                throw CustomException::badRequestException('Product already exists');

            Product::create([
                'name' => strtolower($this->product_name),
                'company_id' => $this->company->id
            ]);
            DB::commit();
            return redirect()->route('admin.company.manager.details', $this->company->id);
        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }


    }
}
