<?php

namespace App\Domain\Formality\Services;

use App\Domain\Enums\ServiceEnum;
use App\Mail\EmailAlarmas;
use App\Mail\EmailLineaTelefonica;
use App\Models\ComponentOption;
use Illuminate\Support\Facades\Mail;

class ServicesBasedOnEmail
{
    public ComponentOption $fibra;
    public ComponentOption $alarma;

    //private array $emails = ['jose.gomez@inmoenergy.es', 'inmobiliarias@inmoenergy.es'];
    private array $emails = ['santiagocarvaja65@hotmail.com'];

    public array $list;
    public array $list_ids;


    public function __construct()
    {
        $this->fibra = ComponentOption::where('name', ServiceEnum::FIBRA)->first();
        $this->alarma = ComponentOption::where('name', ServiceEnum::ALARMA->value)->first();
        $this->list = array(
            $this->fibra,
            $this->alarma
        );
        $this->list_ids = array(
            $this->fibra->id,
            $this->alarma->id
        );
    }

    public function sendMail(int $serviceId, array $client, array $address, array|null $attachs = null)
    {
        switch ($serviceId) {
            case $this->fibra->id:
                Mail::to($this->emails)
                    ->send(new EmailLineaTelefonica($client, $address, $attachs));
                break;
            case $this->alarma->id:
                Mail::to($this->emails)
                    ->send(new EmailAlarmas($client, $address, $attachs));
                break;
        }
    }


}
