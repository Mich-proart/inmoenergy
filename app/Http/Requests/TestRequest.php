<?php

namespace App\Http\Requests;

use App\Domain\Dto\Address\CreateAddressDto;
use App\Domain\Dto\User\CreateUserDto;
use App\Domain\Enums\ClientTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
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
        return [
            'name' => 'required|string',
            'email' => 'required|email',
            'isWorker' => 'required|boolean',
            'locationId' => 'required|integer',
            'streetTypeId' => 'required|integer',
            'streetName' => 'required|string',
            'streetNumber' => 'required|string',
            'zipCode' => 'required|string',
            'block' => 'required|string',
            'floor' => 'required|string',
            'door' => 'required|string',
            'clientType' => [
                'required',
                Rule::in(ClientTypeEnum::cases())
            ]
        ];
    }

    public function CreateAddressDto(): CreateAddressDto
    {
        return new CreateAddressDto($this->locationId, $this->streetTypeId, $this->streetName, $this->streetNumber, $this->zipCode, $this->block, $this->blockStaircase, $this->floor, $this->door);
    }

    public function createUserDto(): CreateUserDto
    {
        return new CreateUserDto($this->name, $this->email, "test", false);
    }
}
