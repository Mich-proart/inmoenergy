<?php

namespace App\Http\Controllers\Admin\Formality;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Domain\Formality\Services\FormalityQueryService;
use Yajra\DataTables\Facades\DataTables;

class FormalityApiController extends Controller
{
    public function __construct(private readonly FormalityQueryService $formalityQueryService)
    {
    }


    public function getInProgress()
    {
        $userId = auth()->user()->id;
        $formality = $this->formalityQueryService->getInProgress($userId);

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
    public function getClosed()
    {
        $userId = auth()->user()->id;
        $formality = $this->formalityQueryService->getClosed($userId);

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
    public function getAssigned()
    {
        $userId = auth()->user()->id;
        $formality = $this->formalityQueryService->getAssigned($userId);

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
    public function getCompleted()
    {
        $userId = auth()->user()->id;
        $formality = $this->formalityQueryService->getCompleted($userId);

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
    public function getPending()
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
    public function getAssignment()
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
    public function getTotalInprogress()
    {
        $formality = $this->formalityQueryService->getTotalInProgress();

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
