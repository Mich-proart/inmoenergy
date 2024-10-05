<?php

namespace App\Http\Controllers\Admin\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Program;
use Illuminate\Http\Request;

class CompanyAdminController extends Controller
{

    public function __construct(

    ) {
        $this->middleware('auth');
        $this->middleware('can:manage.company.access')->only('index', 'details');
        $this->middleware('can:manage.product.access')->only('getProducts');
    }


    public function index()
    {
        $program = Program::where('name', 'gestión de comercializadoras')->first();
        return view('admin.company.manager', ['program' => $program]);
    }
    public function getProducts()
    {
        $program = Program::where('name', 'gestión de productos')->first();
        return view('admin.product.manager', ['program' => $program]);
    }

    public function details(int $id)
    {

        $company = Company::where('id', $id)->first();
        if ($company)
            return view('admin.company.managerDetails', ['company' => $company]);
    }

}
