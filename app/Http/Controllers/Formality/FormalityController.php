<?php

namespace App\Http\Controllers\Formality;

use App\Domain\Address\Services\AddressService;
use App\Domain\Formality\Dtos\FormalityQuery;
use App\Domain\Formality\Services\CreateFormalityService;
use App\Domain\Formality\Services\FormalityService;
use App\Domain\User\Services\UserService;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Formality\CreateFormality;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormalityController extends Controller
{

    public function __construct(
        private UserService $userService,
        private AddressService $addressService,
        private CreateFormalityService $createFormalityService,
        private FormalityService $formalityService
    ) {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $issuerId = $request->query('issuerId');
        $assignedId = $request->query('assignedId');
        $exceptStatus = $request->query('exceptStatus');
        $onlyStatus = $request->query('onlyStatus');
        $activationDateNull = $request->query('activationDateNull');
        $formality = null;

        if ($onlyStatus) {
            $query = new FormalityQuery($issuerId, $assignedId, $activationDateNull, $onlyStatus);
            $formality = $this->formalityService->findByStatus($query);
        }

        if ($exceptStatus) {
            $query = new FormalityQuery($issuerId, $assignedId, $activationDateNull, $exceptStatus);
            $formality = $this->formalityService->findByDistintStatus($query);
        }
        return datatables()->of($formality)
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
            ->toJson();
    }

    public function getPending(Request $request)
    {
        $assignedId = $request->query('assignedId');
        $activation_date_null = $request->query('assignedId');

        $formality = null;

        if ($assignedId && $activation_date_null) {
            $formality = $this->formalityService->getActicationDateNull($assignedId);
        }

        if (!$assignedId && !$activation_date_null) {
            $formality = $this->formalityService->getAssignedNull();
        }

        return datatables()->of($formality)
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
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateFormality $request)
    {
        DB::beginTransaction();

        try {


            DB::commit();
            return redirect()->route('admin.formality.inprogress');
        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
