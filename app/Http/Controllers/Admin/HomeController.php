<?php

namespace App\Http\Controllers\Admin;


use App\Domain\Enums\FormalityStatusEnum;
use App\Domain\Formality\Dtos\FormalityQuery;
use App\Domain\Formality\Services\FormalityQueryService;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;


class HomeController extends Controller
{

    public function __construct(
        private readonly FormalityQueryService $formalityQueryService,
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
                    $query = new FormalityQuery($userId, null, null, [FormalityStatusEnum::TRAMITADO->value, FormalityStatusEnum::EN_VIGOR->value]);
                    $formality = $this->formalityQueryService->findByDistintStatus($query);
                    $program->count = count($formality);
                }

                if ($program->name == 'trámites cerrados') {
                    $query = new FormalityQuery($userId, null, null, [FormalityStatusEnum::TRAMITADO->value, FormalityStatusEnum::EN_VIGOR->value]);
                    $formality = $this->formalityQueryService->findByStatus($query);
                    $program->count = count($formality);
                }
                if ($program->name == 'trámites asignados') {
                    $query = new FormalityQuery(null, $userId, null, [FormalityStatusEnum::TRAMITADO->value, FormalityStatusEnum::EN_VIGOR->value]);
                    $formality = $this->formalityQueryService->findByDistintStatus($query);
                    $program->count = count($formality);
                }

                if ($program->name == 'trámites realizados') {
                    $query = new FormalityQuery(null, $userId, null, [FormalityStatusEnum::TRAMITADO->value, FormalityStatusEnum::EN_VIGOR->value]);
                    $formality = $this->formalityQueryService->findByStatus($query);
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
                    $formality = $this->formalityQueryService->getDistintStatus([FormalityStatusEnum::TRAMITADO->value, FormalityStatusEnum::EN_VIGOR->value]);
                    $program->count = count($formality);
                }
            }
        }

        return view('admin.index', ['sections' => $sections]);
    }

}
