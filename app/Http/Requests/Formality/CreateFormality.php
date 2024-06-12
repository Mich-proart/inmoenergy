<?php

namespace App\Http\Requests\Formality;

use App\Domain\Address\Dtos\CreateAddressDto;
use App\Domain\User\Dtos\CreateUserDetailDto;
use App\Domain\User\Dtos\CreateUserDto;
use App\Http\Requests\commonRules;
use Hash;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateFormality extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    use commonRules;
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return array_merge($this->clientRules(), $this->userDetailRules(), $this->addressRules(), [
            'formalityTypeId' => 'required|exists:formality_type,id',
            'serviceIds' => ['required', 'array', 'exists:service,id'],
            'observation' => ['nullable', 'string', 'max:255']
        ]);
    }

    public function getCreateUserDto(): CreateUserDto
    {
        $pass = substr(md5(uniqid(mt_rand(), true)), 0, 8);
        return new CreateUserDto(
            $this->name,
            $this->email,
            Hash::make($pass),
            false
        );
    }

    public function getCreatUserDetailDto(): CreateUserDetailDto
    {
        return new CreateUserDetailDto(
            $this->firstLastName,
            $this->secondLastName,
            $this->documentTypeId,
            $this->documentNumber,
            $this->phone,
            $this->clientTypeId,
            $this->userTitleId,
            $this->housingTypeId,
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
            $this->streetName,
            $this->streetNumber,
            $this->zipCode,
            $this->block,
            $this->blockstaircase,
            $this->floor,
            $this->door
        );
    }
}
