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
                return $formality->street_type_abbreviation . ' ' . $formality->street_name . ' ' . $formality->street_number . ' ' . $formality->block . ' ' . $formality->block_staircase . ' ' . $formality->floor . ' ' . $formality->door;
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
                return $formality->street_type_abbreviation . ' ' . $formality->street_name . ' ' . $formality->street_number . ' ' . $formality->block . ' ' . $formality->block_staircase . ' ' . $formality->floor . ' ' . $formality->door;
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
                return $formality->street_type_abbreviation . ' ' . $formality->street_name . ' ' . $formality->street_number . ' ' . $formality->block . ' ' . $formality->block_staircase . ' ' . $formality->floor . ' ' . $formality->door;
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
                return $formality->street_type_abbreviation . ' ' . $formality->street_name . ' ' . $formality->street_number . ' ' . $formality->block . ' ' . $formality->block_staircase . ' ' . $formality->floor . ' ' . $formality->door;
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
                return $formality->street_type_abbreviation . ' ' . $formality->street_name . ' ' . $formality->street_number . ' ' . $formality->block . ' ' . $formality->block_staircase . ' ' . $formality->floor . ' ' . $formality->door;
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
                return $formality->street_type_abbreviation . ' ' . $formality->street_name . ' ' . $formality->street_number . ' ' . $formality->block . ' ' . $formality->block_staircase . ' ' . $formality->floor . ' ' . $formality->door;
            })
            ->toJson(true);
    }
    public function getTotalInprogress(Request $request)
    {
        // Log all request parameters
        \Log::info('getTotalInprogress - Request Parameters:', [
            'all_params' => $request->all(),
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
            'assigned_id' => $request->assigned_id,
            'service_id' => $request->service_id,
            'status_id' => $request->status_id,
            'company_id' => $request->company_id,
            'cups' => $request->cups,
            'is_renewable' => $request->is_renewable,
            'issuer_id' => $request->issuer_id,
        ]);

        $queryBuilder = $this->formalityQueryService->getTotalInProgressQuery();

        if ($request->has('date_from') && $request->date_from) {
            \Log::info('getTotalInprogress - Applying date_from filter', ['date_from' => $request->date_from]);
            $queryBuilder->whereDate('formality.created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            \Log::info('getTotalInprogress - Applying date_to filter', ['date_to' => $request->date_to]);
            $queryBuilder->whereDate('formality.created_at', '<=', $request->date_to);
        }
        if ($request->has('assigned_id') && $request->assigned_id) {
            $assignedIds = is_array($request->assigned_id) ? $request->assigned_id : [$request->assigned_id];
            \Log::info('getTotalInprogress - Applying assigned_id filter', ['assigned_ids' => $assignedIds]);
            $queryBuilder->whereIn('userAssigned.id', $assignedIds);
        }
        if ($request->has('service_id') && $request->service_id) {
            $serviceIds = is_array($request->service_id) ? $request->service_id : [$request->service_id];
            \Log::info('getTotalInprogress - Applying service_id filter', ['service_ids' => $serviceIds]);
            $queryBuilder->whereIn('service.id', $serviceIds);
        }
        if ($request->has('status_id') && $request->status_id) {
            $statusIds = is_array($request->status_id) ? $request->status_id : [$request->status_id];
            \Log::info('getTotalInprogress - Applying status_id filter', ['status_ids' => $statusIds]);
            $queryBuilder->whereIn('status.id', $statusIds);
        }
        if ($request->has('company_id') && $request->company_id) {
            $companyIds = is_array($request->company_id) ? $request->company_id : [$request->company_id];
            \Log::info('getTotalInprogress - Applying company_id filter', ['company_ids' => $companyIds]);
            $queryBuilder->whereIn('company.id', $companyIds);
        }
        if ($request->has('cups') && $request->cups) {
            $cupsArray = explode(',', $request->cups);
            \Log::info('getTotalInprogress - Applying cups filter', ['cups_array' => $cupsArray]);
            $queryBuilder->where(function ($q) use ($cupsArray) {
                foreach ($cupsArray as $cup) {
                    $q->orWhere('formality.CUPS', 'like', '%' . trim($cup) . '%');
                }
            });
        }
        if ($request->has('is_renewable') && $request->is_renewable !== null) {
            $renewableIds = is_array($request->is_renewable) ? $request->is_renewable : [$request->is_renewable];
            \Log::info('getTotalInprogress - Applying is_renewable filter', ['renewable_ids' => $renewableIds]);
            $queryBuilder->whereIn('formality.isRenewable', $renewableIds);
        }
        if ($request->has('issuer_id') && $request->issuer_id) {
            $issuerIds = is_array($request->issuer_id) ? $request->issuer_id : [$request->issuer_id];
            \Log::info('getTotalInprogress - Applying issuer_id filter', ['issuer_ids' => $issuerIds]);
            $queryBuilder->whereIn('issuer.id', $issuerIds);
        }

        // Log the SQL query before DataTables processing
        \Log::info('getTotalInprogress - Final SQL Query:', [
            'sql' => $queryBuilder->toSql(),
            'bindings' => $queryBuilder->getBindings()
        ]);

        return DataTables::of($queryBuilder)
            ->setRowAttr(['align' => 'center'])
            ->setRowId(function ($formality) {
                \Log::debug('getTotalInprogress - Processing row', ['formality_id' => $formality->formality_id]);
                return $formality->formality_id;
            })
            ->addColumn('fullName', function ($formality) {
                $fullName = $formality->name . ' ' . $formality->firstLastName . ' ' . $formality->secondLastName;
                \Log::debug('getTotalInprogress - fullName column', [
                    'formality_id' => $formality->formality_id,
                    'fullName' => $fullName
                ]);
                return $fullName;
            })
            ->addColumn('assigned', function ($formality) {
                $assigned = $formality->assigned_name . ' ' . (isset($formality->assigned_firstLastName[0]) ? strtoupper($formality->assigned_firstLastName[0]) . '.' : '');
                \Log::debug('getTotalInprogress - assigned column', [
                    'formality_id' => $formality->formality_id,
                    'assigned' => $assigned
                ]);
                return $assigned;
            })
            ->addColumn('issuer', function ($formality) {
                $issuer = $formality->issuer_name . ' ' . (isset($formality->issuer_firstLastName[0]) ? strtoupper($formality->issuer_firstLastName[0]) . '.' : '');
                \Log::debug('getTotalInprogress - issuer column', [
                    'formality_id' => $formality->formality_id,
                    'issuer' => $issuer
                ]);
                return $issuer;
            })
            ->addColumn('fullAddress', function ($formality) {
                $fullAddress = $formality->street_type_abbreviation . ' ' . $formality->street_name . ' ' . $formality->street_number . ' ' . $formality->block . ' ' . $formality->block_staircase . ' ' . $formality->floor . ' ' . $formality->door;
                \Log::debug('getTotalInprogress - fullAddress column', [
                    'formality_id' => $formality->formality_id,
                    'fullAddress' => $fullAddress
                ]);
                return $fullAddress;
            })
            // Map DataTables column names to actual database columns for filtering
            ->filterColumn('office', function($query, $keyword) {
                $query->where('office.name', 'like', "%{$keyword}%");
            })
            ->filterColumn('business_group', function($query, $keyword) {
                $query->where('business_group.name', 'like', "%{$keyword}%");
            })
            ->filterColumn('issuer', function($query, $keyword) {
                $query->where(function($q) use ($keyword) {
                    $q->where('issuer.name', 'like', "%{$keyword}%")
                      ->orWhere('issuer.first_last_name', 'like', "%{$keyword}%")
                      ->orWhere('issuer.second_last_name', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('assigned', function($query, $keyword) {
                $query->where(function($q) use ($keyword) {
                    $q->where('userAssigned.name', 'like', "%{$keyword}%")
                      ->orWhere('userAssigned.first_last_name', 'like', "%{$keyword}%")
                      ->orWhere('userAssigned.second_last_name', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('type', function($query, $keyword) {
                $query->where('type.name', 'like', "%{$keyword}%");
            })
            ->filterColumn('service', function($query, $keyword) {
                $query->where('service.name', 'like', "%{$keyword}%");
            })
            ->filterColumn('status', function($query, $keyword) {
                $query->where('status.name', 'like', "%{$keyword}%");
            })
            ->filterColumn('fullName', function($query, $keyword) {
                $query->where(function($q) use ($keyword) {
                    $q->where('client.name', 'like', "%{$keyword}%")
                      ->orWhere('client.first_last_name', 'like', "%{$keyword}%")
                      ->orWhere('client.second_last_name', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('documentNumber', function($query, $keyword) {
                $query->where('client.document_number', 'like', "%{$keyword}%");
            })
            ->filterColumn('fullAddress', function($query, $keyword) {
                $query->where(function($q) use ($keyword) {
                    $q->where('address.street_name', 'like', "%{$keyword}%")
                      ->orWhere('address.street_number', 'like', "%{$keyword}%")
                      ->orWhere('location.name', 'like', "%{$keyword}%")
                      ->orWhere('province.name', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('formality_id', function($query, $keyword) {
                $query->where('formality.id', 'like', "%{$keyword}%");
            })
            ->filterColumn('created_at', function($query, $keyword) {
                $query->whereDate('formality.created_at', 'like', "%{$keyword}%");
            })
            ->filterColumn('assignment_date', function($query, $keyword) {
                $query->whereDate('formality.assignment_date', 'like', "%{$keyword}%");
            })
            ->filterColumn('isCritical', function($query, $keyword) {
                $query->where('formality.isCritical', 'like', "%{$keyword}%");
            })
            ->filterColumn('company', function($query, $keyword) {
                $query->where('company.name', 'like', "%{$keyword}%");
            })
            ->filterColumn('CUPS', function($query, $keyword) {
                $query->where('formality.CUPS', 'like', "%{$keyword}%");
            })
            ->filterColumn('isRenewable', function($query, $keyword) {
                $query->where('formality.isRenewable', 'like', "%{$keyword}%");
            })
            ->toJson(true);
    }

    public function getTotalClosed(Request $request)
    {
        // Log all request parameters
        \Log::info('getTotalClosed - Request Parameters:', [
            'all_params' => $request->all(),
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
            'activation_date_from' => $request->activation_date_from,
            'activation_date_to' => $request->activation_date_to,
            'assigned_id' => $request->assigned_id,
            'service_id' => $request->service_id,
            'status_id' => $request->status_id,
            'company_id' => $request->company_id,
            'cups' => $request->cups,
            'is_renewable' => $request->is_renewable,
            'issuer_id' => $request->issuer_id,
        ]);

        $queryBuilder = $this->formalityQueryService->getTotalClosedQuery();

        if ($request->has('date_from') && $request->date_from) {
            \Log::info('getTotalClosed - Applying date_from filter', ['date_from' => $request->date_from]);
            $queryBuilder->whereDate('formality.created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            \Log::info('getTotalClosed - Applying date_to filter', ['date_to' => $request->date_to]);
            $queryBuilder->whereDate('formality.created_at', '<=', $request->date_to);
        }
        if ($request->has('activation_date_from') && $request->activation_date_from) {
            \Log::info('getTotalClosed - Applying activation_date_from filter', ['activation_date_from' => $request->activation_date_from]);
            $queryBuilder->whereDate('formality.activation_date', '>=', $request->activation_date_from);
        }
        if ($request->has('activation_date_to') && $request->activation_date_to) {
            \Log::info('getTotalClosed - Applying activation_date_to filter', ['activation_date_to' => $request->activation_date_to]);
            $queryBuilder->whereDate('formality.activation_date', '<=', $request->activation_date_to);
        }
        if ($request->has('assigned_id') && $request->assigned_id) {
            $assignedIds = is_array($request->assigned_id) ? $request->assigned_id : [$request->assigned_id];
            \Log::info('getTotalClosed - Applying assigned_id filter', ['assigned_ids' => $assignedIds]);
            $queryBuilder->whereIn('userAssigned.id', $assignedIds);
        }
        if ($request->has('service_id') && $request->service_id) {
            $serviceIds = is_array($request->service_id) ? $request->service_id : [$request->service_id];
            \Log::info('getTotalClosed - Applying service_id filter', ['service_ids' => $serviceIds]);
            $queryBuilder->whereIn('service.id', $serviceIds);
        }
        if ($request->has('status_id') && $request->status_id) {
            $statusIds = is_array($request->status_id) ? $request->status_id : [$request->status_id];
            \Log::info('getTotalClosed - Applying status_id filter', ['status_ids' => $statusIds]);
            $queryBuilder->whereIn('status.id', $statusIds);
        }
        if ($request->has('company_id') && $request->company_id) {
            $companyIds = is_array($request->company_id) ? $request->company_id : [$request->company_id];
            \Log::info('getTotalClosed - Applying company_id filter', ['company_ids' => $companyIds]);
            $queryBuilder->whereIn('company.id', $companyIds);
        }
        if ($request->has('cups') && $request->cups) {
            $cupsArray = explode(',', $request->cups);
            \Log::info('getTotalClosed - Applying cups filter', ['cups_array' => $cupsArray]);
            $queryBuilder->where(function ($q) use ($cupsArray) {
                foreach ($cupsArray as $cup) {
                    $q->orWhere('formality.CUPS', 'like', '%' . trim($cup) . '%');
                }
            });
        }
        if ($request->has('is_renewable') && $request->is_renewable !== null) {
            $renewableIds = is_array($request->is_renewable) ? $request->is_renewable : [$request->is_renewable];
            \Log::info('getTotalClosed - Applying is_renewable filter', ['renewable_ids' => $renewableIds]);
            $queryBuilder->whereIn('formality.isRenewable', $renewableIds);
        }
        if ($request->has('issuer_id') && $request->issuer_id) {
            $issuerIds = is_array($request->issuer_id) ? $request->issuer_id : [$request->issuer_id];
            \Log::info('getTotalClosed - Applying issuer_id filter', ['issuer_ids' => $issuerIds]);
            $queryBuilder->whereIn('issuer.id', $issuerIds);
        }

        // Log the SQL query before DataTables processing
        \Log::info('getTotalClosed - Final SQL Query:', [
            'sql' => $queryBuilder->toSql(),
            'bindings' => $queryBuilder->getBindings()
        ]);

        return DataTables::of($queryBuilder)
            ->setRowAttr(['align' => 'center'])
            ->setRowId(function ($formality) {
                \Log::debug('getTotalClosed - Processing row', ['formality_id' => $formality->formality_id]);
                return $formality->formality_id;
            })
            ->addColumn('fullName', function ($formality) {
                $fullName = $formality->name . ' ' . $formality->firstLastName . ' ' . $formality->secondLastName;
                \Log::debug('getTotalClosed - fullName column', [
                    'formality_id' => $formality->formality_id,
                    'fullName' => $fullName
                ]);
                return $fullName;
            })
            ->addColumn('assigned', function ($formality) {
                $assigned = $formality->assigned_name . ' ' . (isset($formality->assigned_firstLastName[0]) ? strtoupper($formality->assigned_firstLastName[0]) . '.' : '');
                \Log::debug('getTotalClosed - assigned column', [
                    'formality_id' => $formality->formality_id,
                    'assigned' => $assigned
                ]);
                return $assigned;
            })
            ->addColumn('issuer', function ($formality) {
                $issuer = $formality->issuer_name . ' ' . (isset($formality->issuer_firstLastName[0]) ? strtoupper($formality->issuer_firstLastName[0]) . '.' : '');
                \Log::debug('getTotalClosed - issuer column', [
                    'formality_id' => $formality->formality_id,
                    'issuer' => $issuer
                ]);
                return $issuer;
            })
            ->addColumn('fullAddress', function ($formality) {
                $fullAddress = $formality->street_type_abbreviation . ' ' . $formality->street_name . ' ' . $formality->street_number . ' ' . $formality->block . ' ' . $formality->block_staircase . ' ' . $formality->floor . ' ' . $formality->door;
                \Log::debug('getTotalClosed - fullAddress column', [
                    'formality_id' => $formality->formality_id,
                    'fullAddress' => $fullAddress
                ]);
                return $fullAddress;
            })
            // Map DataTables column names to actual database columns for filtering
            ->filterColumn('office', function($query, $keyword) {
                $query->where('office.name', 'like', "%{$keyword}%");
            })
            ->filterColumn('business_group', function($query, $keyword) {
                $query->where('business_group.name', 'like', "%{$keyword}%");
            })
            ->filterColumn('issuer', function($query, $keyword) {
                $query->where(function($q) use ($keyword) {
                    $q->where('issuer.name', 'like', "%{$keyword}%")
                      ->orWhere('issuer.first_last_name', 'like', "%{$keyword}%")
                      ->orWhere('issuer.second_last_name', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('assigned', function($query, $keyword) {
                $query->where(function($q) use ($keyword) {
                    $q->where('userAssigned.name', 'like', "%{$keyword}%")
                      ->orWhere('userAssigned.first_last_name', 'like', "%{$keyword}%")
                      ->orWhere('userAssigned.second_last_name', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('type', function($query, $keyword) {
                $query->where('type.name', 'like', "%{$keyword}%");
            })
            ->filterColumn('service', function($query, $keyword) {
                $query->where('service.name', 'like', "%{$keyword}%");
            })
            ->filterColumn('status', function($query, $keyword) {
                $query->where('status.name', 'like', "%{$keyword}%");
            })
            ->filterColumn('fullName', function($query, $keyword) {
                $query->where(function($q) use ($keyword) {
                    $q->where('client.name', 'like', "%{$keyword}%")
                      ->orWhere('client.first_last_name', 'like', "%{$keyword}%")
                      ->orWhere('client.second_last_name', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('documentNumber', function($query, $keyword) {
                $query->where('client.document_number', 'like', "%{$keyword}%");
            })
            ->filterColumn('fullAddress', function($query, $keyword) {
                $query->where(function($q) use ($keyword) {
                    $q->where('address.street_name', 'like', "%{$keyword}%")
                      ->orWhere('address.street_number', 'like', "%{$keyword}%")
                      ->orWhere('location.name', 'like', "%{$keyword}%")
                      ->orWhere('province.name', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('formality_id', function($query, $keyword) {
                $query->where('formality.id', 'like', "%{$keyword}%");
            })
            ->filterColumn('created_at', function($query, $keyword) {
                $query->whereDate('formality.created_at', 'like', "%{$keyword}%");
            })
            ->filterColumn('assignment_date', function($query, $keyword) {
                $query->whereDate('formality.assignment_date', 'like', "%{$keyword}%");
            })
            ->filterColumn('activation_date', function($query, $keyword) {
                $query->whereDate('formality.activation_date', 'like', "%{$keyword}%");
            })
            ->filterColumn('isCritical', function($query, $keyword) {
                $query->where('formality.isCritical', 'like', "%{$keyword}%");
            })
            ->filterColumn('company', function($query, $keyword) {
                $query->where('company.name', 'like', "%{$keyword}%");
            })
            ->filterColumn('CUPS', function($query, $keyword) {
                $query->where('formality.CUPS', 'like', "%{$keyword}%");
            })
            ->filterColumn('isRenewable', function($query, $keyword) {
                $query->where('formality.isRenewable', 'like', "%{$keyword}%");
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
                return $formality->street_type_abbreviation . ' ' . $formality->street_name . ' ' . $formality->street_number . ' ' . $formality->block . ' ' . $formality->block_staircase . ' ' . $formality->floor . ' ' . $formality->door;
            })
            ->toJson(true);
    }
}
