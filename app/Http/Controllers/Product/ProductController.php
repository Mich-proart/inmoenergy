<?php

namespace App\Http\Controllers\Product;

use App\Domain\Product\Services\ProductService;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;
use DB;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $companyId = $request->query('companyId');
        $products = null;

        if ($companyId) {
            $products = $this->getAllByCompanyId($companyId);
        } else {
            $products = $this->getAll();
        }


        return datatables()->of($products)
            ->setRowAttr(['align' => 'center'])
            ->setRowId(function ($product) {
                return $product->product_id;
            })
            ->toJson();
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
