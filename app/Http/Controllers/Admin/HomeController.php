<?php

namespace App\Http\Controllers\Admin;


use App\Domain\Enums\FormalityStatusEnum;
use App\Domain\Formality\Dtos\FormalityQuery;
use App\Domain\Formality\Services\FormalityQueryService;

use App\Domain\Ticket\Services\TicketQueryService;
use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;


class HomeController extends Controller
{

    public function __construct(
        private readonly FormalityQueryService $formalityQueryService,
        private readonly TicketQueryService $ticketQueryService
    ) {
    }

    public function index()
    {
        $role = auth()->user()->roles()->first();
        $roleId = $role->id;
        $userId = auth()->user()->id;

        $sections = Section::with([
            'programs' => function ($query) use ($roleId) {
                $query->whereHas('roles', function ($query) use ($roleId) {
                    $query->where('role_id', $roleId);
                })->orderBy('placed_in', 'asc');
            },
            'programs.roles'
        ])->orderBy('id', 'asc')->get();

        foreach ($sections as $section) {
            foreach ($section->programs as $program) {
                if ($program->name == 'trámites en curso') {
                    $formality = $this->formalityQueryService->getInProgress($userId);
                    $program->count = count($formality);
                }

                if ($program->name == 'trámites cerrados') {
                    $formality = $this->formalityQueryService->getClosed($userId);
                    $program->count = count($formality);
                }
                if ($program->name == 'trámites asignados') {
                    $formality = $this->formalityQueryService->getAssigned($userId);
                    $program->count = count($formality);
                }

                if ($program->name == 'trámites realizados') {
                    $formality = $this->formalityQueryService->getCompleted($userId);
                    $program->count = count($formality);
                }
                //
                if ($program->name == 'altas pendientes fecha activación') {
                    $formality = $this->formalityQueryService->totalPending();
                    $program->count = count($formality);
                }
                if ($program->name == 'asignación de trámite') {
                    $formality = $this->formalityQueryService->getAssignedNull();
                    $program->count = count($formality);
                }
                if ($program->name == 'trámites en curso totales') {
                    $formality = $this->formalityQueryService->getTotalInProgress();
                    $program->count = count($formality);
                }
                if ($program->name == 'tickets pendientes') {
                    $ticket = $this->ticketQueryService->getPending($userId);
                    $program->count = count($ticket);
                }
                if ($program->name == 'tickets resueltos') {
                    $ticket = '';
                    if ($section->name == "trámites y tickets asignados") {
                        $ticket = $this->ticketQueryService->getResolvedWorker($userId);
                    } else {
                        $ticket = $this->ticketQueryService->getResolved($userId);
                    }
                    $program->count = count($ticket);
                }
                if ($program->name == 'tickets asignados') {
                    $ticket = $this->ticketQueryService->getAssigned($userId);
                    $program->count = count($ticket);
                }
                if ($program->name == 'tickets pendientes totales') {
                    $ticket = $this->ticketQueryService->getTotalPending();
                    $program->count = count($ticket);
                }
                if ($program->name == 'asignación de tickets') {
                    $ticket = $this->ticketQueryService->getAssignment();
                    $program->count = count($ticket);
                }
            }
        }

        return view('admin.index', ['sections' => $sections]);
    }

}
