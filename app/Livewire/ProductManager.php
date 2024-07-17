<?php

namespace App\Livewire;

use App\Exceptions\CustomException;
use App\Models\Company;
use App\Models\Product;
use Livewire\Component;

use DB;

class ProductManager extends Component
{

    public Product|null $product = null;

    public $companyId;
    public $name;

    public function render()
    {
        $companies = Company::where('is_available', 1)->get();
        return view('livewire.product-manager', ['companies' => $companies]);
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

    public function save()
    {

        $this->validate();

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

    public function resetVar()
    {
        $this->reset();
    }

}
