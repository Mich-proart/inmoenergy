<?php

namespace App\Domain\Company\Services;

use App\Domain\Company\Dtos\CreateCompanyDto;
use App\Exceptions\CustomException;
use App\Models\Company;
use Illuminate\Contracts\Database\Query\Builder;
use DB;

class CompanyService
{
    public function create(string $name)
    {

        $found = Company::where('name', $name)->first();
        if ($found)
            throw CustomException::badRequestException('Company already exists');

        $company = Company::create([
            'name' => strtolower($name),
        ]);

        return $company;
    }

    private function CompanyQuery(): Builder
    {
        return DB::table('company')->select('company.*');
    }

    public function getAll()
    {
        $query = $this->CompanyQuery();
        $query->whereNotNull('is_available');

        return $query->get();
    }

}