<?php

namespace App\Http\Controllers\Admin\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyAdminController extends Controller
{

    public function __construct(

    ) {
    }

    public function details(int $id)
    {

        $company = Company::where('id', $id)->first();
        if ($company)
            return view('admin.company.managerDetails', ['company' => $company]);
    }

}
