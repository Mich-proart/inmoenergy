<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Domain\Address\Dtos\CreateAddressDto;
use App\Domain\User\Dtos\CreateUserDetailDto;
use App\Domain\User\Dtos\CreateUserDto;
use Hash;
use Livewire\WithFileUploads;

class newFormalityFields extends Form
{
    use WithFileUploads;
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

    public $dni;
    public $factura_agua;
    public $factura_gas;
    public $factura_luz;

    protected $rules = [
        'formalityTypeId' => 'required|exists:component_option,id',
        'serviceIds' => 'required|array|exists:component_option,id',
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email',
        'firstLastName' => 'required|string',
        'secondLastName' => 'required|string',
        'documentTypeId' => 'required|integer|exists:component_option,id',
        'documentNumber' => 'required|string',
        'phone' => 'required|string|spanish_phone',
        'clientTypeId' => 'required|integer|exists:component_option,id',
        'userTitleId' => 'required|integer|exists:component_option,id',
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
        'dni' => 'sometimes|nullable|mimes:pdf|max:1024',
        'factura_agua' => 'sometimes|nullable|mimes:pdf|max:1024',
        'factura_gas' => 'sometimes|nullable|mimes:pdf|max:1024',
        'factura_luz' => 'sometimes|nullable|mimes:pdf|max:1024',
    ];

    public function getCreateUserDto(): CreateUserDto
    {
        $pass = substr(md5(uniqid(mt_rand(), true)), 0, 8);
        return new CreateUserDto(
            $this->name,
            $this->email,
            Hash::make($pass),
            false,
            $this->firstLastName,
            $this->secondLastName,
            $this->documentTypeId,
            $this->documentNumber,
            $this->phone,
            $this->clientTypeId,
            $this->userTitleId,
            $this->IBAN,
            null,
            null,
        );
    }



    public function getCreateAddressDto(): CreateAddressDto
    {
        return new CreateAddressDto(
            $this->locationId,
            $this->streetTypeId,
            $this->housingTypeId,
            $this->streetName,
            $this->streetNumber,
            $this->zipCode,
            $this->block,
            $this->blockstaircase,
            $this->floor,
            $this->door
        );
    }

    public function getCreateClientAddressDto(): CreateAddressDto
    {
        return new CreateAddressDto(
            $this->client_locationId,
            $this->client_streetTypeId,
            $this->client_housingTypeId,
            $this->client_streetName,
            $this->client_streetNumber,
            $this->client_zipCode,
            $this->client_block,
            $this->client_blockstaircase,
            $this->client_floor,
            $this->client_door
        );
    }

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
        'zipCode.required' => 'Codigo postal es requerido',
        'dni.required' => 'DNI es requerido',
        'dni.max' => 'Tamanio maximo de DNI es 1MB',
        'factura_agua.max' => 'Tamanio maximo de Factura de Agua es 1MB',
        'factura_gas.max' => 'Tamanio maximo de Factura de Gas es 1MB',
        'factura_luz.max' => 'Tamanio maximo de Factura de Luz es 1MB'

    ];
}
