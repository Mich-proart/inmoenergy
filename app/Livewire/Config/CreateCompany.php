<?php

namespace App\Livewire\Config;

use Livewire\Component;
use App\Models\Company;
use App\Exceptions\CustomException;
use DB;

class CreateCompany extends Component
{

    public $name;
    public $days_to_renew;

    protected $rules = [
        'name' => 'required|string|max:255',
        'days_to_renew' => 'required|integer|between:1,365',
    ];

    protected $messages = [
        'name.required' => 'Debes introducir un nombre',
        'name.max' => 'El nombre no puede superar los 255 caracteres',
        'days_to_renew.required' => 'Debes introducir un día de renovación',
        'days_to_renew.integer' => 'El día de renovación debe ser un número',
        'days_to_renew.between' => 'El día de renovación debe estar entre 1 y 365 días',
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
                'days_to_renew' => $this->days_to_renew
            ]);
            DB::commit();
            return redirect()->route('admin.company.manager');
        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }

    }


    public function render()
    {
        return view('livewire.config.create-company');
    }
}
