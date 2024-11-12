<?php

namespace App\Mail;

use App\Models\ComponentOption;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailAlarmas extends Mailable
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

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Solicitud de servicio alarma en' . ' ' . $this->streetType->name . ' ' . $this->address['street_name'] . ' ' . $this->address['street_number'] . ' ' . $this->address['block'] . ' ' . $this->address['block_staircase'] . ' ' . $this->address['floor'] . ' ' . $this->address['door']
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'admin.email.alarmas',
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
