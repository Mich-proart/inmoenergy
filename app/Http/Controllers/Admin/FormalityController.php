<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Services\Address\AddressService;
use App\Domain\Services\Formality\CreateFormalityService;
use App\Domain\Services\User\UserService;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Formality\CreateFormality;
use App\Models\ClientType;
use App\Models\DocumentType;
use App\Models\FormalityType;
use App\Models\HousingType;
use App\Models\Service;
use App\Models\UserTitle;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormalityController extends Controller
{
    public function __construct(
        private UserService $userService,
        private AddressService $addressService,
        private CreateFormalityService $createFormalityService
    ) {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.formality.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $documentTypes = DocumentType::all();
        $clientTypes = ClientType::all();
        $userTitles = UserTitle::all();
        $housingTypes = HousingType::all();
        $formalitytypes = FormalityType::all();
        $services = Service::all();
        return view('admin.formality.create', compact(['formalitytypes', 'services', 'documentTypes', 'clientTypes', 'userTitles', 'housingTypes']));
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
