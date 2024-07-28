<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;
use DB;

class CompanyController extends Controller
{


    public function index(Request $request)
    {
        $companies = $this->getAll();
        return datatables()->of($companies)
            ->setRowAttr(['align' => 'center'])
            ->setRowId(function ($company) {
                return $company->id;
            })
            ->toJson();
    }

    private function CompanyQuery(): Builder
    {
        return DB::table('company')->select('company.*');
    }

    public function getAll()
    {
        $query = $this->CompanyQuery();
        $query->where('is_available', 1);

        return $query->get();
    }

}
