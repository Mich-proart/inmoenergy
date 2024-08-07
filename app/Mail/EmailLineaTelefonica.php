<?php

namespace App\Mail;

use App\Domain\Address\Dtos\CreateAddressDto;
use App\Domain\User\Dtos\CreateUserDto;
use App\Models\ComponentOption;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailLineaTelefonica extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */


    public ComponentOption $streetType;
    public $user;
    public $address;

    public function __construct($user, $address)
    {
        $this->user = $user;
        $this->address = $address;
        $this->streetType = ComponentOption::where('id', $this->address->streetTypeId)->first();
    }

    /**
     * Get the message envelope.
     */

    /*
Solicitud de Fibra / línea telefónica “ & [TIPO CALLE] & “ “ & [NOMBRE CALLE]
& “ “ & [NUMERO] & “ “ & [BLOQUE] & “ “ & [ESCALERA] & “ “ & [PISO] & “ “ & [PUERTA]
    */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Solicitud de Fibra / línea telefónica' . ' ' . $this->streetType->name . ' ' . $this->address->streetName . ' ' . $this->address->streetNumber . ' ' . $this->address->block . ' ' . $this->address->door
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'admin.email.fibraLineaTelefonica',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
