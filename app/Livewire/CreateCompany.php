<?php

namespace App\Livewire;

use App\Domain\Company\Services\CompanyService;
use App\Exceptions\CustomException;
use App\Models\Company;
use Livewire\Component;
use Illuminate\Support\Facades\App;
use DB;

class CreateCompany extends Component
{
    public $name;

    // protected $companyService;

    public function __construct()
    {
        // $this->companyService = App::make(CompanyService::class);
    }
    public function render()
    {
        return view('livewire.create-company');
    }

    protected $rules = [
        'name' => 'required|string|max:255'
    ];

    public function save()
    {

        $this->validate();

        DB::beginTransaction();

        try {
            $found = Company::where('name', $this->name)->first();
            if ($found)
                throw CustomException::badRequestException('Company already exists');

            Company::create([
                'name' => strtolower($this->name),
            ]);
            DB::commit();
            return redirect()->route('admin.company.manager');
        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }

    }
}
