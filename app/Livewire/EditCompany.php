<?php

namespace App\Livewire;

use App\Exceptions\CustomException;
use App\Models\Company;
use Livewire\Component;
use DB;

class EditCompany extends Component
{

    public $company_name;
    public $company;

    public function mount($company)
    {
        $this->company = $company;
        $this->company_name = $company->name;
    }

    public function render()
    {
        return view('livewire.edit-company');
    }

    protected $rules = [
        'company_name' => 'required|string|min:3|max:255'
    ];

    public function update()
    {
        $this->validate();

        DB::beginTransaction();

        try {

            $updates = [
                'name' => strtolower($this->company_name),
            ];

            Company::firstWhere('id', $this->company->id)->update($updates);
            DB::commit();
            return redirect()->route('admin.company.manager');
        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }
    }
}
