<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Enums\FormalityStatusEnum;
use App\Domain\Formality\Dtos\FormalityQuery;
use App\Domain\Formality\Services\CountQueryService;
use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;


class HomeController extends Controller
{

    public function __construct(
        private readonly CountQueryService $countQueryService
    ) {
    }

    public function index()
    {

        $roleId = auth()->user()->roles()->first()->id;
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
                    $query = new FormalityQuery($userId, null, null, [FormalityStatusEnum::TRAMITADO->value, FormalityStatusEnum::EN_CURSO->value]);
                    $program->count = $this->countQueryService->findByDistintStatus($query);
                }

                if ($program->name == 'trámites cerrados') {
                    $query = new FormalityQuery($userId, null, null, [FormalityStatusEnum::TRAMITADO->value, FormalityStatusEnum::EN_CURSO->value]);
                    $program->count = $this->countQueryService->findByStatus($query);
                }
                if ($program->name == 'trámites asignados') {
                    $query = new FormalityQuery(null, $userId, null, [FormalityStatusEnum::TRAMITADO->value, FormalityStatusEnum::EN_CURSO->value]);
                    $program->count = $this->countQueryService->findByDistintStatus($query);
                }

                if ($program->name == 'trámites realizados') {
                    $query = new FormalityQuery(null, $userId, null, [FormalityStatusEnum::TRAMITADO->value, FormalityStatusEnum::EN_CURSO->value]);
                    $program->count = $this->countQueryService->findByStatus($query);
                }
                //
                if ($program->name == 'altas pendientes') {

                    $program->count = $this->countQueryService->getActicationDateNull($userId);
                }
                if ($program->name == 'asignación de trámites') {
                    $program->count = $this->countQueryService->getAssignedNull();
                }
                if ($program->name == 'trámites en curso totales') {
                    $query = new FormalityQuery(null, null, null, [FormalityStatusEnum::TRAMITADO->value, FormalityStatusEnum::EN_CURSO->value]);
                    $program->count = $this->countQueryService->findByDistintStatus($query);
                }
            }
        }

        return view('admin.index', ['sections' => $sections]);
    }
}
