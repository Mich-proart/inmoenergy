<?php

namespace App\Http\Controllers\Admin\Company;

use App\Domain\Company\Services\CompanyService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyAdminController extends Controller
{

    public function __construct(
        private readonly CompanyService $companyService
    ) {
    }

    public function details(int $id)
    {

        $company = $this->companyService->getById($id);
        if ($company)
            return view('admin.company.managerDetails', ['company' => $company]);
    }

}
