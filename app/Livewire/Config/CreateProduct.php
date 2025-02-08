<?php

namespace App\Livewire\Config;

use Livewire\Component;
use App\Exceptions\CustomException;
use App\Models\Company;
use App\Models\Product;
use DB;

class CreateProduct extends Component
{

    public Product|null $product = null;

    public $companyId;
    public $name;

    public function setProduct($productId)
    {
        $this->product = Product::find($productId);
        $this->companyId = $this->product->company_id;
        $this->name = $this->product->name;
    }

    protected $rules = [
        'companyId' => 'required|exists:company,id',
        'name' => 'required|max:255|min:3',
    ];

    protected $messages = [
        'name.required' => 'Debes introducir un nombre',
        'name.max' => 'El nombre no puede superar los 255 caracteres',
        'name.min' => 'El nombre debe tener al menos 3 caracteres',
        'name.unique' => 'El nombre ya existe',
        'companyId.required' => 'Debes seleccionar una empresa',
    ];

    public function save()
    {
        $this->validateSaving();

        DB::beginTransaction();

        try {

            if ($this->product !== null) {
                $this->product->update([
                    'name' => strtolower($this->name),
                    'company_id' => $this->companyId
                ]);
                DB::commit();
                return redirect()->route('admin.product.manager');
            }

            Product::create([
                'name' => strtolower($this->name),
                'company_id' => $this->companyId
            ]);
            DB::commit();
            return redirect()->route('admin.product.manager');
        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }

    }


    public function validateSaving()
    {
        $this->validate();
        if ($this->product !== null) {

            if ($this->product->name !== $this->name) {
                $this->validate([
                    'name' => 'unique:product,name',
                ], [
                    'name.unique' => 'El nombre ya existe',
                ]);
            }

        } else {
            $this->validate([
                'name' => 'unique:product,name',
            ], [
                'name.unique' => 'El nombre ya existe',
            ]);
        }
    }

    public function resetVar()
    {
        $this->reset();
    }


    public function render()
    {
        $companies = Company::where('is_available', 1)->get();
        return view('livewire.config.create-product', ['companies' => $companies]);
    }
}
