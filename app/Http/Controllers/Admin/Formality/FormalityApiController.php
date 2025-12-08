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
        $this->middleware('auth');
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
                return $formality->assigned_name . ' ' . (isset($formality->assigned_firstLastName[0]) ? strtoupper($formality->assigned_firstLastName[0]) . '.' : '');
            })
            ->addColumn('issuer', function ($formality) {
                return $formality->issuer_name . ' ' . (isset($formality->issuer_firstLastName[0]) ? strtoupper($formality->issuer_firstLastName[0]) . '.' : '');
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
                return $formality->assigned_name . ' ' . (isset($formality->assigned_firstLastName[0]) ? strtoupper($formality->assigned_firstLastName[0]) . '.' : '');
            })
            ->addColumn('issuer', function ($formality) {
                return $formality->issuer_name . ' ' . (isset($formality->issuer_firstLastName[0]) ? strtoupper($formality->issuer_firstLastName[0]) . '.' : '');
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
                return $formality->assigned_name . ' ' . (isset($formality->assigned_firstLastName[0]) ? strtoupper($formality->assigned_firstLastName[0]) . '.' : '');
            })
            ->addColumn('issuer', function ($formality) {
                return $formality->issuer_name . ' ' . (isset($formality->issuer_firstLastName[0]) ? strtoupper($formality->issuer_firstLastName[0]) . '.' : '');
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
                return $formality->assigned_name . ' ' . (isset($formality->assigned_firstLastName[0]) ? strtoupper($formality->assigned_firstLastName[0]) . '.' : '');
            })
            ->addColumn('issuer', function ($formality) {
                return $formality->issuer_name . ' ' . (isset($formality->issuer_firstLastName[0]) ? strtoupper($formality->issuer_firstLastName[0]) . '.' : '');
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
                return $formality->assigned_name . ' ' . (isset($formality->assigned_firstLastName[0]) ? strtoupper($formality->assigned_firstLastName[0]) . '.' : '');
            })
            ->addColumn('issuer', function ($formality) {
                return $formality->issuer_name . ' ' . (isset($formality->issuer_firstLastName[0]) ? strtoupper($formality->issuer_firstLastName[0]) . '.' : '');
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
                return $formality->assigned_name . ' ' . (isset($formality->assigned_firstLastName[0]) ? strtoupper($formality->assigned_firstLastName[0]) . '.' : '');
            })
            ->addColumn('issuer', function ($formality) {
                return $formality->issuer_name . ' ' . (isset($formality->issuer_firstLastName[0]) ? strtoupper($formality->issuer_firstLastName[0]) . '.' : '');
            })
            ->addColumn('fullAddress', function ($formality) {
                return $formality->street_type . ' ' . $formality->street_name . ' ' . $formality->street_number . ' ' . $formality->block . ' ' . $formality->block_staircase . ' ' . $formality->floor . ' ' . $formality->door;
            })
            ->toJson(true);
    }
    public function getTotalInprogress(Request $request)
    {
        $queryBuilder = $this->formalityQueryService->getTotalInProgressQuery();

        if ($request->has('date_from') && $request->date_from) {
            $queryBuilder->whereDate('formality.created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $queryBuilder->whereDate('formality.created_at', '<=', $request->date_to);
        }
        if ($request->has('assigned_id') && $request->assigned_id) {
            $assignedIds = is_array($request->assigned_id) ? $request->assigned_id : [$request->assigned_id];
            $queryBuilder->whereIn('userAssigned.id', $assignedIds);
        }
        if ($request->has('service_id') && $request->service_id) {
            $serviceIds = is_array($request->service_id) ? $request->service_id : [$request->service_id];
            $queryBuilder->whereIn('service.id', $serviceIds);
        }
        if ($request->has('status_id') && $request->status_id) {
            $statusIds = is_array($request->status_id) ? $request->status_id : [$request->status_id];
            $queryBuilder->whereIn('status.id', $statusIds);
        }
        if ($request->has('company_id') && $request->company_id) {
            $companyIds = is_array($request->company_id) ? $request->company_id : [$request->company_id];
            $queryBuilder->whereIn('company.id', $companyIds);
        }
        if ($request->has('cups') && $request->cups) {
            $cupsArray = explode(',', $request->cups);
            $queryBuilder->where(function ($q) use ($cupsArray) {
                foreach ($cupsArray as $cup) {
                    $q->orWhere('formality.CUPS', 'like', '%' . trim($cup) . '%');
                }
            });
        }
        if ($request->has('is_renewable') && $request->is_renewable !== null) {
            $renewableIds = is_array($request->is_renewable) ? $request->is_renewable : [$request->is_renewable];
            $queryBuilder->whereIn('formality.isRenewable', $renewableIds);
        }
        if ($request->has('issuer_id') && $request->issuer_id) {
            $issuerIds = is_array($request->issuer_id) ? $request->issuer_id : [$request->issuer_id];
            $queryBuilder->whereIn('issuer.id', $issuerIds);
        }

        return DataTables::of($queryBuilder)
            ->setRowAttr(['align' => 'center'])
            ->setRowId(function ($formality) {
                return $formality->formality_id;
            })
            ->addColumn('fullName', function ($formality) {
                return $formality->name . ' ' . $formality->firstLastName . ' ' . $formality->secondLastName;
            })
            ->addColumn('assigned', function ($formality) {
                return $formality->assigned_name . ' ' . (isset($formality->assigned_firstLastName[0]) ? strtoupper($formality->assigned_firstLastName[0]) . '.' : '');
            })
            ->addColumn('issuer', function ($formality) {
                return $formality->issuer_name . ' ' . (isset($formality->issuer_firstLastName[0]) ? strtoupper($formality->issuer_firstLastName[0]) . '.' : '');
            })
            ->addColumn('fullAddress', function ($formality) {
                return $formality->street_type . ' ' . $formality->street_name . ' ' . $formality->street_number . ' ' . $formality->block . ' ' . $formality->block_staircase . ' ' . $formality->floor . ' ' . $formality->door;
            })
            ->toJson(true);
    }

    public function getTotalClosed(Request $request)
    {
        $queryBuilder = $this->formalityQueryService->getTotalClosedQuery();

        if ($request->has('date_from') && $request->date_from) {
            $queryBuilder->whereDate('formality.created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $queryBuilder->whereDate('formality.created_at', '<=', $request->date_to);
        }
        if ($request->has('activation_date_from') && $request->activation_date_from) {
            $queryBuilder->whereDate('formality.activation_date', '>=', $request->activation_date_from);
        }
        if ($request->has('activation_date_to') && $request->activation_date_to) {
            $queryBuilder->whereDate('formality.activation_date', '<=', $request->activation_date_to);
        }
        if ($request->has('assigned_id') && $request->assigned_id) {
            $assignedIds = is_array($request->assigned_id) ? $request->assigned_id : [$request->assigned_id];
            $queryBuilder->whereIn('userAssigned.id', $assignedIds);
        }
        if ($request->has('service_id') && $request->service_id) {
            $serviceIds = is_array($request->service_id) ? $request->service_id : [$request->service_id];
            $queryBuilder->whereIn('service.id', $serviceIds);
        }
        if ($request->has('status_id') && $request->status_id) {
            $statusIds = is_array($request->status_id) ? $request->status_id : [$request->status_id];
            $queryBuilder->whereIn('status.id', $statusIds);
        }
        if ($request->has('company_id') && $request->company_id) {
            $companyIds = is_array($request->company_id) ? $request->company_id : [$request->company_id];
            $queryBuilder->whereIn('company.id', $companyIds);
        }
        if ($request->has('cups') && $request->cups) {
            $cupsArray = explode(',', $request->cups);
            $queryBuilder->where(function ($q) use ($cupsArray) {
                foreach ($cupsArray as $cup) {
                    $q->orWhere('formality.CUPS', 'like', '%' . trim($cup) . '%');
                }
            });
        }
        if ($request->has('is_renewable') && $request->is_renewable !== null) {
            $renewableIds = is_array($request->is_renewable) ? $request->is_renewable : [$request->is_renewable];
            $queryBuilder->whereIn('formality.isRenewable', $renewableIds);
        }
        if ($request->has('issuer_id') && $request->issuer_id) {
            $issuerIds = is_array($request->issuer_id) ? $request->issuer_id : [$request->issuer_id];
            $queryBuilder->whereIn('issuer.id', $issuerIds);
        }

        return DataTables::of($queryBuilder)
            ->setRowAttr(['align' => 'center'])
            ->setRowId(function ($formality) {
                return $formality->formality_id;
            })
            ->addColumn('fullName', function ($formality) {
                return $formality->name . ' ' . $formality->firstLastName . ' ' . $formality->secondLastName;
            })
            ->addColumn('assigned', function ($formality) {
                return $formality->assigned_name . ' ' . (isset($formality->assigned_firstLastName[0]) ? strtoupper($formality->assigned_firstLastName[0]) . '.' : '');
            })
            ->addColumn('issuer', function ($formality) {
                return $formality->issuer_name . ' ' . (isset($formality->issuer_firstLastName[0]) ? strtoupper($formality->issuer_firstLastName[0]) . '.' : '');
            })
            ->addColumn('fullAddress', function ($formality) {
                return $formality->street_type . ' ' . $formality->street_name . ' ' . $formality->street_number . ' ' . $formality->block . ' ' . $formality->block_staircase . ' ' . $formality->floor . ' ' . $formality->door;
            })
            ->toJson(true);
    }
    public function getRenewable()
    {
        $formality = $this->formalityQueryService->getRenewable();

        return DataTables::of($formality)
            ->setRowAttr(['align' => 'center'])
            ->setRowId(function ($formality) {
                return $formality->formality_id;
            })
            ->addColumn('fullName', function ($formality) {
                return $formality->name . ' ' . $formality->firstLastName . ' ' . $formality->secondLastName;
            })
            ->addColumn('fullAddress', function ($formality) {
                return $formality->street_type . ' ' . $formality->street_name . ' ' . $formality->street_number . ' ' . $formality->block . ' ' . $formality->block_staircase . ' ' . $formality->floor . ' ' . $formality->door;
            })
            ->toJson(true);
    }
}
