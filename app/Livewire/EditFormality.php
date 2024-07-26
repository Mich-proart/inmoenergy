<?php

namespace App\Livewire;

use App\Domain\Address\Services\AddressService;
use App\Domain\Enums\ClientTypeEnum;
use App\Domain\Enums\DocumentRule;
use App\Domain\Enums\DocumentTypeEnum;
use App\Domain\Formality\Services\FormalityService;
use App\Domain\User\Services\UserService;
use App\Exceptions\CustomException;
use App\Livewire\Forms\updateFormalityFields;
use App\Models\Address;
use App\Models\ComponentOption;
use App\Models\Formality;
use Livewire\Component;
use Illuminate\Support\Facades\App;
use DB;
use Livewire\Attributes\Computed;

class EditFormality extends Component
{
    protected $formalityService;
    protected $addressService;
    protected $userService;

    // fields
    public updateFormalityFields $form;
    public int $formalityId;
    public $formality;

    public $target_provinceId;
    public $target_clientProvinceId;

    public $businessClientType;
    public $businessDocumentType;

    public $documentTypes;

    public $field_name = 'Nombre';

    public $isBusinessPerson = false;

    public function __construct()
    {
        $this->userService = App::make(UserService::class);
        $this->formalityService = App::make(FormalityService::class);
        $this->addressService = App::make(AddressService::class);

        $this->businessClientType = ComponentOption::where('name', ClientTypeEnum::BUSINESS->value)->first();
        $this->businessDocumentType = ComponentOption::where('name', DocumentTypeEnum::CIF->value)->first();
    }


    public function mount($formalityId)
    {
        $this->formalityId = $formalityId;
        $this->formality = $this->formalityService->getById($formalityId);
        $this->form->setformality($this->formality);
        $this->target_provinceId = $this->form->provinceId;
        $this->target_clientProvinceId = $this->form->client_provinceId;
        $this->documentTypes = $this->userService->getDocumentTypes();

        $this->clientTypeId = $this->form->clientTypeId;

        if ($this->clientTypeId == $this->businessClientType->id) {
            $this->isBusinessPerson = true;
            $this->field_name = 'Razon social';
        }

    }

    public function render()
    {

        $clientTypes = $this->userService->getClientTypes();
        $userTitles = $this->userService->getUserTitles();
        $formalitytypes = $this->formalityService->getFormalityTypes();
        $services = $this->formalityService->getServices();
        $streetTypes = $this->addressService->getStreetTypes();
        $housingTypes = $this->addressService->getHousingTypes();
        return view('livewire.edit-formality', [
            'streetTypes' => $streetTypes,
            'housingTypes' => $housingTypes,
            'formalitytypes' => $formalitytypes,
            'services' => $services,
            'clientTypes' => $clientTypes,
            'userTitles' => $userTitles,
        ]);
    }

    public function update()
    {

        $this->formValidation();


        DB::beginTransaction();

        try {

            $data = Formality::firstWhere('id', $this->formalityId);
            $data->client()->update($this->form->getclientUpdate());

            $address = Address::firstWhere('id', $data->address->id);
            $address->update($this->form->getaddressUpdate());

            if ($data->CorrespondenceAddress !== null) {
                $corresponceAddress = Address::firstWhere('id', $data->CorrespondenceAddress->id);
                $corresponceAddress->update($this->form->getCorresponceAddressUpdate());
            }

            $data->update($this->form->getFormalityUpdate());

            $data->save();

            DB::commit();
            return redirect()->route('admin.formality.inprogress');
        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }
    }

    #[Computed()]

    public function provinces()
    {
        $province = $this->addressService->getProvinces();
        return $province;
    }
    #[Computed()]
    public function locations()
    {
        $locations = $this->addressService->getLocations((int) $this->target_provinceId);
        return $locations;
    }

    #[Computed()]
    public function clientProvinces()
    {
        $clientProvince = $this->addressService->getProvinces();
        return $clientProvince;
    }

    #[Computed()]
    public function clientLocations()
    {
        $clientLocation = $this->addressService->getLocations((int) $this->target_clientProvinceId);
        return $clientLocation;
    }

    public function formstate()
    {
        $current_client_type = null;


        if ($this->form->clientTypeId !== null) {
            $this->documentTypes = $this->userService->getDocumentTypes();
            $current_client_type = ComponentOption::where('id', $this->form->clientTypeId)->first();

            if ($current_client_type && $current_client_type->name === ClientTypeEnum::BUSINESS->value) {

                $this->field_name = 'Razon social';
                $this->isBusinessPerson = true;

                $documentType = $this->userService->getDocumentTypes();
                $documentType = $documentType->where('name', DocumentTypeEnum::CIF->value)->first();

                $this->form->setDocumentTypeId($documentType->id);
                $this->form->reset(['firstLastName', 'secondLastName', 'userTitleId']);


            }

            if ($current_client_type && $current_client_type->name === ClientTypeEnum::PERSON->value) {
                $this->field_name = 'Nombre';
                $this->isBusinessPerson = false;
                $documentTypes = $this->userService->getDocumentTypes();
                $this->documentTypes = $documentTypes->where('name', '!=', DocumentTypeEnum::CIF->value);
            }

        }
    }

    private function formValidation()
    {
        $this->form->validate();

        $selectedClientType = ComponentOption::where('id', $this->form->clientTypeId)->first();
        $selectedDocumentType = ComponentOption::where('id', $this->form->documentTypeId)->first();
        if ($selectedClientType && $selectedClientType->name === ClientTypeEnum::PERSON->value) {

            $documentRule = '';

            if ($selectedDocumentType && $selectedDocumentType->name === DocumentTypeEnum::PASSPORT->value) {
                $documentRule = 'required|string|min:9|max:9';
            } elseif ($selectedDocumentType && $selectedDocumentType->name === DocumentTypeEnum::DNI->value) {
                $documentRule = DocumentRule::$DNI;
            } elseif ($selectedDocumentType && $selectedDocumentType->name === DocumentTypeEnum::NIE->value) {
                $documentRule = DocumentRule::$NIE;
            }

            $this->form->validate(
                [
                    'firstLastName' => 'required|string',
                    'secondLastName' => 'required|string',
                    'userTitleId' => 'required|integer|exists:component_option,id',
                    'documentNumber' => $documentRule
                ],
                [

                    'firstLastName.required' => 'El campo Primer Apellido es obligatorio',
                    'secondLastName.required' => 'El campo Segundo Apellido es obligatorio',
                    'userTitleId.required' => 'El campo Titulo es obligatorio',
                    'userTitleId.exists' => 'El Titulo no es valido',

                ]
            );
        }


        if ($selectedClientType && $selectedClientType->name === ClientTypeEnum::BUSINESS->value) {
            $this->form->validate(
                [
                    'documentNumber' => DocumentRule::$CIF
                ],
                [
                    'documentNumber.required' => 'El campo Cif es obligatorio',
                    'documentNumber.cif' => 'El Cif no es valido',
                ],
            );
        }

    }
}
