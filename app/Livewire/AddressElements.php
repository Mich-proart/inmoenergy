<?php

namespace App\Livewire;

use App\Domain\Services\Address\AddressService;
use App\Models\Address;
use Illuminate\Support\Facades\App;
use Livewire\Attributes\Computed;
use Livewire\Component;

class AddressElements extends Component
{

    protected $addressService;
    public function __construct()
    {
        $this->addressService = App::make(AddressService::class);
    }
    public $provinceId;
    public $locationId;

    #[Computed()]

    public function provinces()
    {
        $province = $this->addressService->getProvinces();
        return $province;
    }
    #[Computed()]
    public function locations()
    {
        $locations = $this->addressService->getLocations((int) $this->provinceId);
        return $locations;
    }

    public function render()
    {
        return view('livewire.address-elements');
    }
}
