<?php

namespace App\Http\Controllers\Formality;

use App\Domain\Dto\Formality\FormalityQuery;
use App\Domain\Services\Address\AddressService;
use App\Domain\Services\Formality\CreateFormalityService;
use App\Domain\Services\Formality\FormalityService;
use App\Domain\Services\User\UserService;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Formality\CreateFormality;
use Auth;
use DB;
use Illuminate\Http\Request;

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


        if ($onlyStatus) {
            $query = new FormalityQuery($issuerId, $assignedId, $activationDateNull, $onlyStatus);
            $formality = $this->formalityService->findByStatus($query);
            return datatables()->of($formality)->toJson();
        }

        if ($exceptStatus) {
            $query = new FormalityQuery($issuerId, $assignedId, $activationDateNull, $exceptStatus);
            $formality = $this->formalityService->findByDistintStatus($query);
            return datatables()->of($formality)->toJson();
        }

        $query = new FormalityQuery($issuerId, $assignedId, $activationDateNull, $onlyStatus);
        $formality = $this->formalityService->findByDistintStatus($query);
        return datatables()->of($formality)->toJson();
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

            $user = $this->userService->create($request->getCreateUserDto());

            $address = $this->addressService->createAddress($request->getCreateAddressDto());


            $userdetails = $request->getCreatUserDetailDto();
            $userdetails->setUserId($user->id);
            $userdetails->setAddressId($address->id);
            $this->userService->setUserDetails($userdetails);

            $this->createFormalityService->setClientId($user->id);
            $this->createFormalityService->setUserIssuerId(Auth::user()->id);

            foreach ($request->serviceIds as $serviceId) {
                $this->createFormalityService->execute($serviceId, $request->formalityTypeId, $request->observation);
            }

            DB::commit();
            return redirect()->route('admin.formality.index');
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
