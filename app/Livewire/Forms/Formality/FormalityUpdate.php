<?php

namespace App\Livewire\Forms\Formality;

use Livewire\Form;

class FormalityUpdate extends Form
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

    public $is_foreign_account = false;

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
        $this->is_foreign_account = $client->is_foreign_account ?? false;
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

        //$this->is_same_address = $formality->isSameCorrespondenceAddress;

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
            'user_title_id' => $this->userTitleId == 0 ? null : $this->userTitleId,
            'phone' => $this->phone,
            'document_number' => $this->documentNumber,
            'document_type_id' => $this->documentTypeId,
            'IBAN' => $this->IBAN,
            'is_foreign_account' => $this->is_foreign_account
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
            'assigned_observation' => $this->assigned_observation,
            //'isSameCorrespondenceAddress' => $this->is_same_address
        ];
    }

    public function rules()
    {
        return [
            'formalityTypeId' => 'required|nullable|exists:component_option,id',
            'serviceIds' => 'required|nullable|exists:component_option,id',
            'name' => 'required|nullable|string',
            'email' => 'nullable|email',
            'documentTypeId' => 'required|nullable|integer|exists:component_option,id',
            //'phone' => 'required|nullable|string|spanish_phone',
            'clientTypeId' => 'required|nullable|integer|exists:component_option,id',
            'IBAN' => $this->is_foreign_account ? 'required|nullable|string' : 'required|nullable|string|iban',
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
            'client_zipCode' => 'sometimes|nullable|spanish_postal_code',
            'client_block' => 'sometimes|nullable|string',
            'client_blockstaircase' => 'sometimes|nullable|string',
            'client_floor' => 'sometimes|nullable|string',
            'client_door' => 'sometimes|nullable|string',
            'observation' => 'sometimes|nullable|string|max:255',
            'assigned_observation' => 'sometimes|nullable|string|max:255'
        ];
    }

    protected $messages = [
        'formalityTypeId.required' => 'Tipo de formulario es requerido',
        'formalityTypeId.exists' => 'El tipo de formulario seleccionado no es válido',
        'serviceIds.required' => 'Servicio es requerido',
        'serviceIds.exists' => 'El servicio seleccionado no es válido',
        'name.required' => 'Nombre es requerido',
        'name.string' => 'El nombre debe ser una cadena de texto',
        'email.required' => 'Email es requerido',
        'email.email' => 'Email no es valido',
        'email.unique' => 'Email ya se encuentra registrado',
        'firstLastName.required' => 'Primer apellido es requerido',
        'firstLastName.string' => 'El primer apellido debe ser una cadena de texto',
        'secondLastName.required' => 'Segundo apellido es requerido',
        'secondLastName.string' => 'El segundo apellido debe ser una cadena de texto',
        'documentTypeId.required' => 'Tipo de documento es requerido',
        'documentTypeId.integer' => 'Tipo de documento no es valido',
        'documentTypeId.exists' => 'El tipo de documento seleccionado no es válido',
        'documentNumber.required' => 'Numero de documento es requerido',
        'documentNumber.string' => 'El número de documento debe ser una cadena de texto',
        'phone.required' => 'Telefono es requerido',
        'phone.string' => 'El teléfono debe ser una cadena de texto',
        'clientTypeId.required' => 'Tipo de cliente es requerido',
        'clientTypeId.integer' => 'El tipo de cliente no es válido',
        'clientTypeId.exists' => 'El tipo de cliente seleccionado no es válido',
        'userTitleId.required' => 'Titulo es requerido',
        'userTitleId.integer' => 'El título no es válido',
        'userTitleId.exists' => 'El título seleccionado no es válido',
        'IBAN.required' => 'Cuenta bancaria es requerido',
        'IBAN.string' => 'La cuenta bancaria debe ser una cadena de texto',
        'IBAN.iban' => 'El IBAN no es válido',
        'locationId.required' => 'Locacion es requerido',
        'locationId.exists' => 'La ubicación seleccionada no es válida',
        'streetTypeId.required' => 'Tipo de calle es requerido',
        'streetTypeId.exists' => 'El tipo de calle seleccionado no es válido',
        'housingTypeId.required' => 'Tipo de vivienda es requerido',
        'housingTypeId.exists' => 'El tipo de vivienda seleccionado no es válido',
        'streetName.required' => 'Nombre de calle es requerido',
        'streetName.string' => 'El nombre de calle debe ser una cadena de texto',
        'streetNumber.required' => 'N° de calle es requerido',
        'streetNumber.string' => 'El número de calle debe ser una cadena de texto',
        'zipCode.required' => 'Codigo postal es requerido',
        'zipCode.string' => 'El código postal debe ser una cadena de texto',
        'zipCode.spanish_postal_code' => 'El código postal no es válido',
        'block.string' => 'El bloque debe ser una cadena de texto',
        'blockstaircase.string' => 'La escalera debe ser una cadena de texto',
        'floor.string' => 'El piso debe ser una cadena de texto',
        'door.string' => 'La puerta debe ser una cadena de texto',
        'dni.required' => 'DNI es requerido',
        'dni.max' => 'Tamanio maximo de DNI es 1MB',
        'factura_agua.max' => 'Tamanio maximo de Factura de Agua es 1MB',
        'factura_gas.max' => 'Tamanio maximo de Factura de Gas es 1MB',
        'factura_luz.max' => 'Tamanio maximo de Factura de Luz es 1MB',
        'client_locationId.integer' => 'Locacion no es valido',
        'client_locationId.exists' => 'La ubicación de correspondencia seleccionada no es válida',
        'client_streetTypeId.integer' => 'Tipo de calle no es valido',
        'client_streetTypeId.exists' => 'El tipo de calle de correspondencia seleccionado no es válido',
        'client_housingTypeId.integer' => 'Tipo de vivienda no es valido',
        'client_housingTypeId.exists' => 'El tipo de vivienda de correspondencia seleccionado no es válido',
        'client_streetName.string' => 'El nombre de calle de correspondencia debe ser una cadena de texto',
        'client_streetNumber.string' => 'El número de calle de correspondencia debe ser una cadena de texto',
        'client_zipCode.spanish_postal_code' => 'Codigo postal no es valido',
        'client_zipCode.required' => 'Codigo postal es requerido',
        'client_zipCode.string' => 'El código postal de correspondencia debe ser una cadena de texto',
        'client_block.string' => 'El bloque de correspondencia debe ser una cadena de texto',
        'client_blockstaircase.string' => 'La escalera de correspondencia debe ser una cadena de texto',
        'client_floor.string' => 'El piso de correspondencia debe ser una cadena de texto',
        'client_door.string' => 'La puerta de correspondencia debe ser una cadena de texto',
        'observation.max' => 'Tamanio maximo de observacion es 255',
        'observation.string' => 'La observación debe ser una cadena de texto',
        'assigned_observation.max' => 'Tamanio maximo de observacion asignada es 255',
        'assigned_observation.string' => 'La observación asignada debe ser una cadena de texto',
    ];

    public function setDocumentTypeId(int $value)
    {
        $this->documentTypeId = $value;
    }
}
