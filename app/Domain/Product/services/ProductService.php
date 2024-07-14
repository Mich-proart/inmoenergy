<?php

namespace App\Domain\Product\Services;

use App\Exceptions\CustomException;
use App\Models\Product;
use Illuminate\Contracts\Database\Query\Builder;
use DB;

class ProductService
{

    public function create(string $name, int $companyId)
    {

        $found = Product::where('name', $name)->first();
        if ($found)
            throw CustomException::badRequestException('Company already exists');

        $product = Product::create([
            'name' => strtolower($name),
            'company_id' => $companyId
        ]);

        return $product;
    }

    private function productQuery(): Builder
    {
        return DB::table('product')
            ->leftJoin('company', 'company.id', '=', 'product.company_id')
            ->select(
                'product.id as product_id',
                'product.name as product_name',
                'product.company_id as company_id',
                'company.name as company_name',
                'product.created_at as created_at'
            );
    }

    public function getAllByCompanyId(int $companyId)
    {
        $query = $this->productQuery();
        $query->where('product.is_available', 1);
        $query->where('product.company_id', $companyId);

        return $query->get();
    }
    public function getAll()
    {
        $query = $this->productQuery();
        $query->where('product.is_available', 1);
        return $query->get();
    }

}