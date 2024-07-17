<?php

namespace App\Livewire;

use App\Exceptions\CustomException;
use App\Models\Product;
use Livewire\Component;
use DB;

class EditProductModal extends Component
{

    public $product;

    public $companyId;
    public $name;

    public function render()
    {
        return view('livewire.edit-product-modal');
    }

    public function setProduct($productId)
    {
        $this->product = Product::find($productId);
        $this->companyId = $this->product->company_id;
        $this->name = $this->product->name;
    }

    protected $rules = [
        'companyId' => 'required|exists:company,id',
        'name' => 'required|max:255|min:3|unique:product,name',
    ];

    protected $messages = [
        'name.required' => 'Debes introducir un nombre',
        'name.max' => 'El nombre no puede superar los 255 caracteres',
        'name.min' => 'El nombre debe tener al menos 3 caracteres',
        'name.unique' => 'El nombre ya existe',
    ];

    public function save()
    {

        $this->validate();

        DB::beginTransaction();

        try {
            $found = Product::where('name', $this->name)->first();
            if ($found)
                throw CustomException::badRequestException('Product already exists');

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
}
