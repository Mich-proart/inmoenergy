<?php

namespace App\Livewire\Client;

use App\Domain\Address\Services\AddressService;
use App\Domain\User\Services\UserService;
use App\Models\Address;
use App\Models\Client;
use App\Models\ComponentOption;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class ViewClientRecords extends Component
{
    use WithPagination;

    // Search properties
    public $search_full_name = '';
    public $search_document_number = '';
    public $search_client_type_id = 0;

    // Selected client and address
    public $selectedClient = null;
    public $selectedAddress = null;

    // Province selection for address
    public $target_provinceId;

    protected $userService;
    protected $addressService;

    public function __construct()
    {
        $this->userService = App::make(UserService::class);
        $this->addressService = App::make(AddressService::class);
    }

    #[Computed()]
    public function provinces()
    {
        return $this->addressService->getProvinces();
    }

    #[Computed()]
    public function locations()
    {
        return $this->addressService->getLocations((int)$this->target_provinceId);
    }

    public function canSearch(): bool
    {
        return !empty($this->search_full_name) || !empty($this->search_document_number) || !empty($this->search_client_type_id);
    }

    public function selectClient($id)
    {
        $this->selectedClient = Client::with([
            'clientType',
            'documentType',
            'title',
            'country',
            'addresses.location.province',
            'addresses.streetType',
            'addresses.housingType'
        ])->find($id);

        if ($this->selectedClient) {
            // Select first address if available
            if ($this->selectedClient->addresses->count() > 0) {
                $this->selectAddress($this->selectedClient->addresses->first()->id);
            }
        }
    }

    public function selectAddress($id)
    {
        $this->selectedAddress = Address::with(['location.province', 'streetType', 'housingType'])->find($id);

        if ($this->selectedAddress) {
            // Set province for location dropdown
            if ($this->selectedAddress->location) {
                $this->target_provinceId = $this->selectedAddress->location->province_id;
            }
        }
    }

    public function render()
    {
        $clientTypes = $this->userService->getClientTypes();
        $documentTypes = $this->userService->getDocumentTypes();
        $userTitles = $this->userService->getUserTitles();
        $streetTypes = $this->addressService->getStreetTypes();
        $housingTypes = $this->addressService->getHousingTypes();

        $clients = [];
        $target_search_name = array('name', 'first_last_name', 'second_last_name');
        
        // Get logged-in user ID
        $userId = Auth::id();

        if ($this->canSearch()) {
            // Filter clients by logged-in user's emitted formalities
            $query = Client::whereHas('formalities', function ($query) use ($userId) {
                $query->where('user_issuer_id', $userId);
            });

            $targets = explode(' ', $this->search_full_name);

            foreach ($target_search_name as $index => $value) {
                if (isset($targets[$index]) && $targets[$index] !== '') {
                    $query->where($value, 'like', '%' . $targets[$index] . '%');
                }
            }

            if (!empty($this->search_document_number)) {
                $query->where('document_number', $this->search_document_number);
            }

            if (!empty($this->search_client_type_id)) {
                $query->where('client_type_id', $this->search_client_type_id);
            }

            $clients = $query->with(['clientType'])->paginate(10);
        }

        return view('livewire.client.view-client-records', [
            'clients' => $clients,
            'clientTypes' => $clientTypes,
            'documentTypes' => $documentTypes,
            'userTitles' => $userTitles,
            'streetTypes' => $streetTypes,
            'housingTypes' => $housingTypes,
        ]);
    }
}
