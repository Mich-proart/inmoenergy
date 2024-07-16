<?php

namespace App\Domain\Company\Services;

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
        $query->where('is_available', 1);

        return $query->get();
    }

    public function getByid(int $id)
    {
        return Company::where('id', $id)->first();
    }

}