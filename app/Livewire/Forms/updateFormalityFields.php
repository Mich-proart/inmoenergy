<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class updateFormalityFields extends Form
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

    public $provinceId;
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
    public $client_provinceId;
    public $client_streetTypeId;
    public $client_housingTypeId;
    public $client_streetName;
    public $client_streetNumber;
    public $client_zipCode;
    public $client_block;
    public $client_blockstaircase;
    public $client_floor;
    public $client_door;

    public bool $is_same_address;

    public $assigned_observation;
    public $observation;

    public function setformality($formality)
    {

        $client = $formality->client;
        $address = $formality->address;
        $CorrespondenceAddress = $formality->CorrespondenceAddress;

        $this->formalityTypeId[0] = $formality->type->id;
        $this->serviceIds[0] = $formality->service->id;
        $this->clientTypeId = $client->clientType->id;
        $this->userTitleId = $client->title->id ?? 0;
        $this->name = $client->name;
        $this->email = $client->email;
        $this->firstLastName = $client->first_last_name;
        $this->secondLastName = $client->second_last_name;
        $this->documentTypeId = $client->documentType->id;
        $this->documentNumber = $client->document_number;
        $this->phone = $client->phone;
        $this->IBAN = $client->IBAN;
        $this->provinceId = $address->location->province->id;
        $this->locationId = $address->location->id;
        $this->streetTypeId = $address->streetType->id;
        $this->housingTypeId = $address->housingType->id;
        $this->streetName = $address->street_name;
        $this->streetNumber = $address->street_number;
        $this->zipCode = $address->zip_code;
        $this->block = $address->block;
        $this->blockstaircase = $address->block_staircase;
        $this->floor = $address->floor;
        $this->door = $address->door;

        $this->is_same_address = $formality->isSameCorrespondenceAddress;

        if (isset($CorrespondenceAddress)) {
            $this->client_provinceId = $CorrespondenceAddress->location->province->id;
            $this->client_locationId = $CorrespondenceAddress->location->id;
            $this->client_streetTypeId = $CorrespondenceAddress->streetType->id;
            $this->client_streetTypeId = $CorrespondenceAddress->streetType->id;
            $this->client_housingTypeId = $CorrespondenceAddress->housingType->id;
            $this->client_streetName = $CorrespondenceAddress->street_name;
            $this->client_streetNumber = $CorrespondenceAddress->street_number;
            $this->client_zipCode = $CorrespondenceAddress->zip_code;
            $this->client_block = $CorrespondenceAddress->block;
            $this->client_blockstaircase = $CorrespondenceAddress->block_staircase;
            $this->client_floor = $CorrespondenceAddress->floor;
            $this->client_door = $CorrespondenceAddress->door;

        }

        $this->assigned_observation = $formality->assigned_observation;
        $this->observation = $formality->observation;


    }

    public function getclientUpdate()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'first_last_name' => $this->firstLastName,
            'second_last_name' => $this->secondLastName,
            'phone' => $this->phone,
            'document_number' => $this->documentNumber,
            'document_type_id' => $this->documentTypeId,
            'IBAN' => $this->IBAN
        ];
    }

    public function getaddressUpdate()
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
            'door' => $this->door
        ];
    }
    public function getCorresponceAddressUpdate()
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
            'door' => $this->client_door
        ];
    }

    public function getFormalityUpdate()
    {
        return [
            'service_id' => $this->serviceIds[0],
            'observation' => $this->observation,
            'formality_type_id' => $this->formalityTypeId[0],
            'assigned_observation' => $this->assigned_observation
        ];
    }

    protected $rules = [
        'formalityTypeId' => 'required|nullable|exists:component_option,id',
        'serviceIds' => 'required|nullable|exists:component_option,id',
        'name' => 'required|nullable|string',
        'email' => 'required|nullable|email',
        // 'firstLastName' => 'required|nullable|string',
        // 'secondLastName' => 'required|nullable|string',
        'documentTypeId' => 'required|nullable|integer|exists:component_option,id',
        // 'documentNumber' => 'required|nullable|string',
        'phone' => 'required|nullable|string|spanish_phone',
        'clientTypeId' => 'required|nullable|integer|exists:component_option,id',
        // 'userTitleId' => 'required|nullable|integer|exists:component_option,id',
        'IBAN' => 'required|nullable|string|iban',
        'locationId' => 'required|nullable|exists:location,id',
        'streetTypeId' => 'required|nullable|exists:component_option,id',
        'housingTypeId' => 'required|nullable|exists:component_option,id',
        'streetName' => 'required|nullable|string',
        'streetNumber' => 'required|nullable|string',
        'zipCode' => 'required|nullable|string|spanish_postal_code',
        'block' => 'sometimes|nullable|string',
        'blockstaircase' => 'sometimes|nullable|string',
        'floor' => 'sometimes|nullable|string',
        'door' => 'sometimes|nullable|string',
        'client_locationId' => 'sometimes|nullable|integer|exists:location,id',
        'client_streetTypeId' => 'sometimes|nullable|integer|exists:component_option,id',
        'client_housingTypeId' => 'sometimes|nullable|integer|exists:component_option,id',
        'client_streetName' => 'sometimes|nullable|string',
        'client_streetNumber' => 'sometimes|nullable|string',
        'client_zipCode' => 'sometimes|nullable|string',
        'client_block' => 'sometimes|nullable|string',
        'client_blockstaircase' => 'sometimes|nullable|string',
        'client_floor' => 'sometimes|nullable|string',
        'client_door' => 'sometimes|nullable|string',
        'observation' => 'sometimes|nullable|string|max:255',
        'assigned_observation' => 'sometimes|nullable|string|max:255'
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
        'locationId.required' => 'Locacion es requerido',
        'streetTypeId.required' => 'Tipo de calle es requerido',
        'housingTypeId.required' => 'Tipo de vivienda es requerido',
        'streetName.required' => 'Nombre de calle es requerido',
        'streetNumber.required' => 'N° de calle es requerido',
        'zipCode.required' => 'Codigo postal es requerido',
        'dni.required' => 'DNI es requerido',
        'dni.max' => 'Tamanio maximo de DNI es 1MB',
        'factura_agua.max' => 'Tamanio maximo de Factura de Agua es 1MB',
        'factura_gas.max' => 'Tamanio maximo de Factura de Gas es 1MB',
        'factura_luz.max' => 'Tamanio maximo de Factura de Luz es 1MB',
    ];

    public function setDocumentTypeId(int $value)
    {
        $this->documentTypeId = $value;
    }

}
