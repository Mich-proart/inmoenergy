<?php

namespace App\Livewire\Client;

use App\Domain\Address\Services\AddressService;
use App\Domain\Enums\ClientTypeEnum;
use App\Domain\Enums\DocumentRule;
use App\Domain\Enums\DocumentTypeEnum;
use App\Domain\User\Services\UserService;
use App\Models\Address;
use App\Models\Client;
use App\Models\ComponentOption;
use App\Models\Country;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class ViewEditClientRecord extends Component
{
    use WithPagination;

    // Search properties
    public $search_full_name = '';
    public $search_document_number = '';
    public $search_client_type_id = 0;

    // Selected client and address
    public $selectedClient = null;
    public $selectedAddress = null;

    // Edit mode flags
    public $editingClient = false;
    public $editingAddress = false;

    // Client form data
    public $clientForm = [
        'name' => '',
        'first_last_name' => '',
        'second_last_name' => '',
        'email' => '',
        'client_type_id' => '',
        'document_type_id' => '',
        'document_number' => '',
        'phone' => '',
        'IBAN' => '',
        'user_title_id' => '',
        'country_id' => '',
        'is_foreign_account' => false,
    ];

    // Address form data
    public $addressForm = [
        'location_id' => '',
        'street_type_id' => '',
        'housing_type_id' => '',
        'street_name' => '',
        'street_number' => '',
        'zip_code' => '',
        'block' => '',
        'block_staircase' => '',
        'floor' => '',
        'door' => '',
    ];

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
            // Load client data into form
            $this->clientForm = [
                'name' => $this->selectedClient->name,
                'first_last_name' => $this->selectedClient->first_last_name,
                'second_last_name' => $this->selectedClient->second_last_name,
                'email' => $this->selectedClient->email,
                'client_type_id' => $this->selectedClient->client_type_id,
                'document_type_id' => $this->selectedClient->document_type_id,
                'document_number' => $this->selectedClient->document_number,
                'phone' => $this->selectedClient->phone,
                'IBAN' => $this->selectedClient->IBAN,
                'user_title_id' => $this->selectedClient->user_title_id,
                'country_id' => $this->selectedClient->country_id,
                'is_foreign_account' => $this->selectedClient->is_foreign_account ?? false,
            ];

            // Select first address if available
            if ($this->selectedClient->addresses->count() > 0) {
                $this->selectAddress($this->selectedClient->addresses->first()->id);
            }

            $this->editingClient = false;
            $this->editingAddress = false;
        }
    }

    public function selectAddress($id)
    {
        $this->selectedAddress = Address::with(['location.province', 'streetType', 'housingType'])->find($id);

        if ($this->selectedAddress) {
            // Load address data into form
            $this->addressForm = [
                'location_id' => $this->selectedAddress->location_id,
                'street_type_id' => $this->selectedAddress->street_type_id,
                'housing_type_id' => $this->selectedAddress->housing_type_id,
                'street_name' => $this->selectedAddress->street_name,
                'street_number' => $this->selectedAddress->street_number,
                'zip_code' => $this->selectedAddress->zip_code,
                'block' => $this->selectedAddress->block,
                'block_staircase' => $this->selectedAddress->block_staircase,
                'floor' => $this->selectedAddress->floor,
                'door' => $this->selectedAddress->door,
            ];

            // Set province for location dropdown
            if ($this->selectedAddress->location) {
                $this->target_provinceId = $this->selectedAddress->location->province_id;
            }

            $this->editingAddress = false;
        }
    }

    public function enableClientEdit()
    {
        $this->editingClient = true;
    }

    public function enableAddressEdit()
    {
        $this->editingAddress = true;
    }

    public function saveClient()
    {
        // Get country for phone validation
        $country = Country::find($this->clientForm['country_id']);
        $phoneRule = 'required|string|phone:' . ($country ? $country->iso2 : 'ES');
        
        // Get client type and document type for validation
        $selectedClientType = ComponentOption::find($this->clientForm['client_type_id']);
        $selectedDocumentType = ComponentOption::find($this->clientForm['document_type_id']);
        
        // Base validation rules
        $rules = [
            'clientForm.name' => 'required|string|max:255',
            'clientForm.email' => 'nullable|email',
            'clientForm.client_type_id' => 'required|exists:component_option,id',
            'clientForm.document_type_id' => 'required|exists:component_option,id',
            'clientForm.phone' => $phoneRule,
            'clientForm.IBAN' => $this->clientForm['is_foreign_account'] ? 'nullable|string' : 'nullable|string|iban',
            'clientForm.country_id' => 'required|exists:country,id',
            'clientForm.is_foreign_account' => 'boolean',
        ];
        
        $messages = [
            'clientForm.phone.phone' => 'El campo debe ser un teléfono válido.',
            'clientForm.IBAN.iban' => 'El IBAN no es válido.',
        ];
        
        // Document number validation based on type
        if ($selectedDocumentType) {
            if ($selectedDocumentType->name === DocumentTypeEnum::DNI->value) {
                $rules['clientForm.document_number'] = DocumentRule::$DNI;
            } elseif ($selectedDocumentType->name === DocumentTypeEnum::NIE->value) {
                $rules['clientForm.document_number'] = DocumentRule::$NIE;
            } elseif ($selectedDocumentType->name === DocumentTypeEnum::CIF->value) {
                $rules['clientForm.document_number'] = DocumentRule::$CIF;
            } elseif ($selectedDocumentType->name === DocumentTypeEnum::PASSPORT->value) {
                $rules['clientForm.document_number'] = 'required|string|min:9|max:9';
            } else {
                $rules['clientForm.document_number'] = 'required|string';
            }
        } else {
            $rules['clientForm.document_number'] = 'required|string';
        }
        
        // Additional rules for person type
        if ($selectedClientType && $selectedClientType->name === ClientTypeEnum::PERSON->value) {
            $rules['clientForm.first_last_name'] = 'required|string|max:255';
            $rules['clientForm.second_last_name'] = 'nullable|string|max:255';
            $rules['clientForm.user_title_id'] = 'required|exists:component_option,id';
            $messages['clientForm.user_title_id.required'] = 'El campo Título es obligatorio';
        } else {
            // For business, these fields are not required
            $rules['clientForm.first_last_name'] = 'nullable|string|max:255';
            $rules['clientForm.second_last_name'] = 'nullable|string|max:255';
            $rules['clientForm.user_title_id'] = 'nullable|exists:component_option,id';
        }

        $this->validate($rules, $messages);

        try {
            $this->selectedClient->update($this->clientForm);
            $this->selectedClient->refresh();
            $this->selectedClient->load(['clientType', 'documentType', 'title', 'country']);
            
            $this->editingClient = false;
            
            $this->dispatch('client-updated', title: 'Éxito', message: 'Cliente actualizado correctamente');
        } catch (\Exception $e) {
            $this->dispatch('client-error', title: 'Error', message: 'Error al actualizar el cliente: ' . $e->getMessage());
        }
    }

    public function saveAddress()
    {
        $this->validate([
            'addressForm.location_id' => 'required|exists:location,id',
            'addressForm.street_type_id' => 'required|exists:component_option,id',
            'addressForm.housing_type_id' => 'required|exists:component_option,id',
            'addressForm.street_name' => 'required|string|max:255',
            'addressForm.street_number' => 'required|string|max:50',
            'addressForm.zip_code' => 'required|string|spanish_postal_code',
            'addressForm.block' => 'nullable|string|max:50',
            'addressForm.block_staircase' => 'nullable|string|max:50',
            'addressForm.floor' => 'nullable|string|max:50',
            'addressForm.door' => 'nullable|string|max:50',
        ]);

        try {
            $this->selectedAddress->update($this->addressForm);
            $this->selectedAddress->refresh();
            $this->selectedAddress->load(['location.province', 'streetType', 'housingType']);
            
            // Refresh client to update addresses
            $this->selectedClient->refresh();
            $this->selectedClient->load(['addresses.location.province', 'addresses.streetType', 'addresses.housingType']);
            
            $this->editingAddress = false;
            
            $this->dispatch('address-updated', title: 'Éxito', message: 'Dirección actualizada correctamente');
        } catch (\Exception $e) {
            $this->dispatch('address-error', title: 'Error', message: 'Error al actualizar la dirección: ' . $e->getMessage());
        }
    }

    public function cancelClientEdit()
    {
        // Reload client data from database
        if ($this->selectedClient) {
            $this->clientForm = [
                'name' => $this->selectedClient->name,
                'first_last_name' => $this->selectedClient->first_last_name,
                'second_last_name' => $this->selectedClient->second_last_name,
                'email' => $this->selectedClient->email,
                'client_type_id' => $this->selectedClient->client_type_id,
                'document_type_id' => $this->selectedClient->document_type_id,
                'document_number' => $this->selectedClient->document_number,
                'phone' => $this->selectedClient->phone,
                'IBAN' => $this->selectedClient->IBAN,
                'user_title_id' => $this->selectedClient->user_title_id,
                'country_id' => $this->selectedClient->country_id,
                'is_foreign_account' => $this->selectedClient->is_foreign_account ?? false,
            ];
        }
        $this->editingClient = false;
    }

    public function cancelAddressEdit()
    {
        // Reload address data from database
        if ($this->selectedAddress) {
            $this->addressForm = [
                'location_id' => $this->selectedAddress->location_id,
                'street_type_id' => $this->selectedAddress->street_type_id,
                'housing_type_id' => $this->selectedAddress->housing_type_id,
                'street_name' => $this->selectedAddress->street_name,
                'street_number' => $this->selectedAddress->street_number,
                'zip_code' => $this->selectedAddress->zip_code,
                'block' => $this->selectedAddress->block,
                'block_staircase' => $this->selectedAddress->block_staircase,
                'floor' => $this->selectedAddress->floor,
                'door' => $this->selectedAddress->door,
            ];
        }
        $this->editingAddress = false;
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
        $query = Client::query();

        if ($this->canSearch()) {
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

        return view('livewire.client.view-edit-client-record', [
            'clients' => $clients,
            'clientTypes' => $clientTypes,
            'documentTypes' => $documentTypes,
            'userTitles' => $userTitles,
            'streetTypes' => $streetTypes,
            'housingTypes' => $housingTypes,
        ]);
    }
}
