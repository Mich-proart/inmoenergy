<?php

namespace App\Http\Controllers\Company;

use App\Domain\Company\Services\CompanyService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyController extends Controller
{

    public function __construct(
        private readonly CompanyService $companyService
    ) {
    }

    public function index(Request $request)
    {
        $companies = $this->companyService->getAll();
        return datatables()->of($companies)
            ->setRowAttr(['align' => 'center'])
            ->setRowId(function ($company) {
                return $company->id;
            })
            ->toJson();
    }

}
