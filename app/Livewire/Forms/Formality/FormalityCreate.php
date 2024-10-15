<?php

namespace App\Livewire\Forms\Formality;

use Livewire\Attributes\Validate;
use Livewire\Form;
use Hash;

class FormalityCreate extends Form
{
    public $formalityTypeId = [];
    public $serviceIds = [];

    public $clientTypeId;
    public $userTitleId;
    public $name;
    public $email;
    public $firstLastName;
    public $secondLastName;
    public $documentTypeId;
    public $documentNumber;
    public $phone;
    public $IBAN;
    public $locationId;
    public $streetTypeId;
    public $housingTypeId;
    public $streetName;
    public $streetNumber;
    public $zipCode;
    public $block;
    public $blockstaircase;
    public $floor;
    public $door;

    public $client_locationId;
    public $client_streetTypeId;
    public $client_housingTypeId;
    public $client_streetName;
    public $client_streetNumber;
    public $client_zipCode;
    public $client_block;
    public $client_blockstaircase;
    public $client_floor;
    public $client_door;

    public $is_same_address = true;
    public $observation;

    public $prove;

    protected $rules = [
        'formalityTypeId' => 'required|exists:component_option,id',
        'serviceIds' => 'required|array|exists:component_option,id',
        'name' => 'required|string',
        'email' => 'required|email', //'required|email|unique:client,email',
        'documentTypeId' => 'required|integer|exists:component_option,id',
        //'phone' => 'required|string|spanish_phone',
        'clientTypeId' => 'required|integer|exists:component_option,id',
        'IBAN' => 'required|string|iban',
        'locationId' => 'required|integer|exists:location,id',
        'streetTypeId' => 'required|integer|exists:component_option,id',
        'housingTypeId' => 'required|integer|exists:component_option,id',
        'streetName' => 'required|string',
        'streetNumber' => 'required|string',
        'zipCode' => 'required|string|spanish_postal_code',
        'block' => 'sometimes|nullable|string',
        'blockstaircase' => 'sometimes|nullable|string',
        'floor' => 'sometimes|nullable|string',
        'door' => 'sometimes|nullable|string',
        'client_locationId' => 'sometimes|nullable|integer|exists:location,id',
        'client_streetTypeId' => 'sometimes|nullable|integer|exists:component_option,id',
        'client_housingTypeId' => 'sometimes|nullable|integer|exists:component_option,id',
        'client_streetName' => 'sometimes|nullable|string',
        'client_streetNumber' => 'sometimes|nullable|string',
        'client_zipCode' => 'sometimes|nullable|string|spanish_postal_code',
        'client_block' => 'sometimes|nullable|string',
        'client_blockstaircase' => 'sometimes|nullable|string',
        'client_floor' => 'sometimes|nullable|string',
        'client_door' => 'sometimes|nullable|string',
        'observation' => 'sometimes|nullable|string|max:255',
    ];

    protected $messages = [
        'formalityTypeId.required' => 'Tipo de formulario es requerido',
        'serviceIds.required' => 'Servicio es requerido',
        'name.required' => 'Nombre es requerido',
        'email.required' => 'Email es requerido',
        'email.email' => 'Email no es valido',
        'email.unique' => 'Email ya se encuentra registrado',
        'firstLastName.required' => 'Primer apellido es requerido',
        'documentTypeId.required' => 'Tipo de documento es requerido',
        'documentTypeId.integer' => 'Tipo de documento no es valido',
        'documentNumber.required' => 'Numero de documento es requerido',
        'phone.required' => 'Telefono es requerido',
        'clientTypeId.required' => 'Tipo de cliente es requerido',
        'userTitleId.required' => 'Titulo es requerido',
        'IBAN.required' => 'Cuenta bancaria es requerido',
        'IBAN.iban' => 'El IBAN introducido no es válido',
        'locationId.required' => 'Locacion es requerido',
        'streetTypeId.required' => 'Tipo de calle es requerido',
        'housingTypeId.required' => 'Tipo de vivienda es requerido',
        'streetName.required' => 'Nombre de calle es requerido',
        'streetNumber.required' => 'N° de calle es requerido',
        'zipCode.required' => 'Codigo postal es requerido'
    ];

    public function setDocumentTypeId(int $value)
    {
        $this->documentTypeId = $value;
    }

    public function getClientDto()
    {
        return [
            'name' => $this->name,
            'first_last_name' => $this->firstLastName,
            'second_last_name' => $this->secondLastName,
            'email' => $this->email,
            'client_type_id' => $this->clientTypeId,
            'document_type_id' => $this->documentTypeId,
            'document_number' => $this->documentNumber,
            'phone' => $this->phone,
            'IBAN' => $this->IBAN,
            'user_title_id' => $this->userTitleId,
        ];
    }



    public function getCreateAddressDto()
    {
        return [
            'location_id' => $this->locationId,
            'street_type_id' => $this->streetTypeId,
            'housing_type_id' => $this->housingTypeId,
            'street_name' => $this->streetName,
            'street_number' => $this->streetNumber,
            'zip_code' => $this->zipCode,
            'block' => $this->block,
            'block_staircase' => $this->blockstaircase,
            'floor' => $this->floor,
            'door' => $this->door,
        ];
    }

    public function getCreateClientAddressDto()
    {
        return [
            'location_id' => $this->client_locationId,
            'street_type_id' => $this->client_streetTypeId,
            'housing_type_id' => $this->client_housingTypeId,
            'street_name' => $this->client_streetName,
            'street_number' => $this->client_streetNumber,
            'zip_code' => $this->client_zipCode,
            'block' => $this->client_block,
            'block_staircase' => $this->client_blockstaircase,
            'floor' => $this->client_floor,
            'door' => $this->client_door,
        ];
    }


}
