<?php

namespace App\Livewire\Ticket;

use App\Domain\Enums\TicketStatusEnum;
use App\Domain\Ticket\Services\TicketService;
use App\Exceptions\CustomException;
use App\Models\Formality;
use App\Models\Status;
use App\Models\Ticket;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class CreateTicketForm extends Component
{

    use WithPagination;

    public $search = "";
    public $search_street = "";

    public $title;
    public $description;
    public $ticketTypeId;
    public $formalityId;
    public Status $defaultStatus;

    public $issuer;

    protected $ticketService;

    public function __construct()
    {
        $this->ticketService = App::make(TicketService::class);
        $this->defaultStatus = Status::where('name', TicketStatusEnum::PENDIENTE->value)->first();
    }

    protected $rules = [
        'title' => 'required|string',
        'description' => 'required|string'
    ];

    protected $messages = [
        'title.required' => 'Valor requerido',
        'title.string' => 'Valor invalido',
        'title.min' => 'Debe ser al menos de 8 caracteres',
        'description.required' => 'Valor requerido',
        'description.string' => 'Valor invalido',
        'description.min' => 'Debe ser al menos de 8 caracteres',
    ];

    public function mount()
    {
        $this->issuer = User::with(['office'])->firstWhere('id', Auth::user()->id);
    }


    #[Computed()]
    public function types()
    {
        return $this->ticketService->getTicketTypes();
    }


    public function save()
    {

        if ($this->formalityId == '' || $this->formalityId == null || $this->formalityId == 0) {
            $this->dispatch('checks', error: "Error al intentar crear un ticket sin seleccionar un trámite.", title: "Datos invalidos");
        } elseif ($this->ticketTypeId == '' || $this->ticketTypeId == null || $this->ticketTypeId == 0) {
            $this->dispatch('checks', error: "Error al intentar crear un ticket sin seleccionar un tipo.", title: "Datos invalidos");
        } else {
            $this->validate();
            DB::beginTransaction();

            try {

                Ticket::create($this->getDataTicket());

                DB::commit();
                return redirect()->route('admin.ticket.pending');

            } catch (\Throwable $th) {

                DB::rollBack();
                throw CustomException::badRequestException($th->getMessage());
            }

        }

    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function getDataTicket()
    {
        return [
            'user_issuer_id' => Auth::user()->id,
            'formality_id' => $this->formalityId,
            'ticket_title' => strtolower($this->title),
            'ticket_description' => strtolower($this->description),
            'ticket_type_id' => $this->ticketTypeId,
            'status_id' => $this->defaultStatus->id
        ];
    }


    public function render()
    {

        $formalities = [];

        $target_search = array('name', 'first_last_name', 'second_last_name');


        $query = Formality::query();

        if ($this->search !== '' || $this->search_street !== '') {

            $targets = explode(' ', $this->search);

            foreach ($target_search as $index => $value) {
                if (isset($targets[$index]) && $targets[$index] !== '') {
                    $query->whereHas('client', function ($query) use ($value, $targets, $index) {
                        $query->where($value, 'like', '%' . $targets[$index] . '%');
                    });
                }
            }

            if ($this->search_street !== '') {
                $query->whereHas('address', function ($query) {
                    $query->where('street_name', 'like', '%' . $this->search_street . '%');
                });
            }

            $query->whereHas('issuer', function ($query) {
                $query->whereHas('office', function ($query) {
                    $query->where('id', $this->issuer->office_id);
                });
            });

            $formalities = $query->with(['service', 'address.streetType'])->paginate(10);
        }

        return view('livewire.ticket.create-ticket-form', ['formalities' => $formalities]);
    }
}
