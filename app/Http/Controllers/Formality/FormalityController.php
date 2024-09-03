<?php

namespace App\Http\Controllers\Formality;

use App\Domain\Enums\FormalityStatusEnum;
use App\Domain\Formality\Dtos\FormalityQuery;
use App\Domain\Formality\Services\FormalityQueryService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FormalityController extends Controller
{

    public function __construct(
        private readonly FormalityQueryService $formalityQueryService,
    ) {
    }

    public function exceptStatus(Request $request)
    {
        $issuerId = $request->query('issuerId');
        $assignedId = $request->query('assignedId');
        $exceptStatus = $request->query('exceptStatus');

        $formality = null;

        if ($exceptStatus) {
            $query = new FormalityQuery($issuerId, $assignedId, null, $exceptStatus);
            $formality = $this->formalityQueryService->findByDistintStatus($query);
        }

        return DataTables::of($formality)
            ->setRowAttr(['align' => 'center'])
            ->setRowId(function ($formality) {
                return $formality->formality_id;
            })
            ->addColumn('fullName', function ($formality) {
                return $formality->name . ' ' . $formality->firstLastName . ' ' . $formality->secondLastName;
            })
            ->addColumn('assigned', function ($formality) {
                return $formality->assigned_name . ' ' . $formality->assigned_firstLastName . ' ' . $formality->assigned_secondLastName;
            })
            ->addColumn('issuer', function ($formality) {
                return $formality->issuer_name . ' ' . $formality->issuer_firstLastName . ' ' . $formality->issuer_secondLastName;
            })
            ->addColumn('fullAddress', function ($formality) {
                return $formality->street_type . ' ' . $formality->street_name . ' ' . $formality->street_number . ' ' . $formality->block . ' ' . $formality->block_staircase . ' ' . $formality->floor . ' ' . $formality->door;
            })
            ->toJson(true);
    }
    public function onlyStatus(Request $request)
    {
        $issuerId = $request->query('issuerId');
        $assignedId = $request->query('assignedId');
        $onlyStatus = $request->query('onlyStatus');

        $formality = null;


        if ($onlyStatus) {
            $query = new FormalityQuery($issuerId, $assignedId, null, $onlyStatus);
            $formality = $this->formalityQueryService->findByStatus($query);
        }

        return DataTables::of($formality)
            ->setRowAttr(['align' => 'center'])
            ->setRowId(function ($formality) {
                return $formality->formality_id;
            })
            ->addColumn('fullName', function ($formality) {
                return $formality->name . ' ' . $formality->firstLastName . ' ' . $formality->secondLastName;
            })
            ->addColumn('assigned', function ($formality) {
                return $formality->assigned_name . ' ' . $formality->assigned_firstLastName . ' ' . $formality->assigned_secondLastName;
            })
            ->addColumn('issuer', function ($formality) {
                return $formality->issuer_name . ' ' . $formality->issuer_firstLastName . ' ' . $formality->issuer_secondLastName;
            })
            ->addColumn('fullAddress', function ($formality) {
                return $formality->street_type . ' ' . $formality->street_name . ' ' . $formality->street_number . ' ' . $formality->block . ' ' . $formality->block_staircase . ' ' . $formality->floor . ' ' . $formality->door;
            })
            ->toJson(true);
    }

    public function totalPending()
    {
        $formality = $this->formalityQueryService->totalPending();

        return DataTables::of($formality)
            ->setRowAttr(['align' => 'center'])
            ->setRowId(function ($formality) {
                return $formality->formality_id;
            })
            ->addColumn('fullName', function ($formality) {
                return $formality->name . ' ' . $formality->firstLastName . ' ' . $formality->secondLastName;
            })
            ->addColumn('assigned', function ($formality) {
                return $formality->assigned_name . ' ' . $formality->assigned_firstLastName . ' ' . $formality->assigned_secondLastName;
            })
            ->addColumn('issuer', function ($formality) {
                return $formality->issuer_name . ' ' . $formality->issuer_firstLastName . ' ' . $formality->issuer_secondLastName;
            })
            ->addColumn('fullAddress', function ($formality) {
                return $formality->street_type . ' ' . $formality->street_name . ' ' . $formality->street_number . ' ' . $formality->block . ' ' . $formality->block_staircase . ' ' . $formality->floor . ' ' . $formality->door;
            })
            ->toJson(true);
    }

    public function getAssignedNull()
    {
        $formality = $this->formalityQueryService->getAssignedNull();

        return DataTables::of($formality)
            ->setRowAttr(['align' => 'center'])
            ->setRowId(function ($formality) {
                return $formality->formality_id;
            })
            ->addColumn('fullName', function ($formality) {
                return $formality->name . ' ' . $formality->firstLastName . ' ' . $formality->secondLastName;
            })
            ->addColumn('assigned', function ($formality) {
                return $formality->assigned_name . ' ' . $formality->assigned_firstLastName . ' ' . $formality->assigned_secondLastName;
            })
            ->addColumn('issuer', function ($formality) {
                return $formality->issuer_name . ' ' . $formality->issuer_firstLastName . ' ' . $formality->issuer_secondLastName;
            })
            ->addColumn('fullAddress', function ($formality) {
                return $formality->street_type . ' ' . $formality->street_name . ' ' . $formality->street_number . ' ' . $formality->block . ' ' . $formality->block_staircase . ' ' . $formality->floor . ' ' . $formality->door;
            })
            ->toJson(true);
    }
    public function getDistintStatus()
    {
        $formality = $this->formalityQueryService->getDistintStatus([FormalityStatusEnum::TRAMITADO->value, FormalityStatusEnum::EN_VIGOR->value]);

        return DataTables::of($formality)
            ->setRowAttr(['align' => 'center'])
            ->setRowId(function ($formality) {
                return $formality->formality_id;
            })
            ->addColumn('fullName', function ($formality) {
                return $formality->name . ' ' . $formality->firstLastName . ' ' . $formality->secondLastName;
            })
            ->addColumn('assigned', function ($formality) {
                return $formality->assigned_name . ' ' . $formality->assigned_firstLastName . ' ' . $formality->assigned_secondLastName;
            })
            ->addColumn('issuer', function ($formality) {
                return $formality->issuer_name . ' ' . $formality->issuer_firstLastName . ' ' . $formality->issuer_secondLastName;
            })
            ->addColumn('fullAddress', function ($formality) {
                return $formality->street_type . ' ' . $formality->street_name . ' ' . $formality->street_number . ' ' . $formality->block . ' ' . $formality->block_staircase . ' ' . $formality->floor . ' ' . $formality->door;
            })
            ->toJson(true);
    }

}
