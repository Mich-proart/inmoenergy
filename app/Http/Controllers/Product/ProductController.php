<?php

namespace App\Http\Controllers\Product;

use App\Domain\Product\Services\ProductService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductService $productService
    ) {
    }

    public function index(Request $request)
    {
        $companyId = $request->query('companyId');
        $products = null;

        if ($companyId) {
            $products = $this->productService->getAllByCompanyId($companyId);
        } else {
            $products = $this->productService->getAll();
        }


        return datatables()->of($products)
            ->setRowAttr(['align' => 'center'])
            ->setRowId(function ($product) {
                return $product->product_id;
            })
            ->toJson();
    }
}
