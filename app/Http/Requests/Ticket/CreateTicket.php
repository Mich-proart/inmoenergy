<?php

namespace App\Http\Requests\Ticket;

use App\Domain\Ticket\Dtos\CreateTicketDto;
use Illuminate\Foundation\Http\FormRequest;

class CreateTicket extends FormRequest
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
            'formalityId' => 'required|exists:formality,id',
            'ticketTypeId' => 'required|exists:ticket_type,id',
            'title' => 'required|string',
            'description' => 'required|string',
        ];
    }

    public function getCreateTicketDto(): CreateTicketDto
    {
        return new CreateTicketDto(
            $this->formalityId,
            $this->ticketTypeId,
            $this->title,
            $this->description
        );
    }
}
