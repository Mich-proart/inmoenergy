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
use Illuminate\Mail\Mailables\Attachment;

class EmailLineaTelefonica extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */


    public ComponentOption $streetType;
    public $user;
    public $address;

    public $attchs;

    public function __construct($user, $address, $attchs)
    {
        $this->user = $user;
        $this->address = $address;
        $this->attchs = $attchs;
        $this->streetType = ComponentOption::where('id', $this->address['street_type_id'])->first();
    }

    /**sla
     * Get the message envelope.
     */

    /*
Solicitud de Fibra / línea telefónica “ & [TIPO CALLE] & “ “ & [NOMBRE CALLE]
& “ “ & [NUMERO] & “ “ & [BLOQUE] & “ “ & [ESCALERA] & “ “ & [PISO] & “ “ & [PUERTA]
    */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Solicitud de Fibra / línea telefónica' . ' ' . $this->streetType->name . ' ' . $this->address['street_name'] . ' ' . $this->address['street_number'] . ' ' . $this->address['block'] . ' ' . $this->address['block_staircase'] . ' ' . $this->address['floor'] . ' ' . $this->address['door']
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
        if ($this->attchs) {
            return $this->attchs;
        }
        return [];
    }
}
