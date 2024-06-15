<?php

namespace App\Http\Controllers\Admin\Formality;

use App\Domain\Formality\Services\FormalityService;
use App\Domain\User\Services\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreateFormalityController extends Controller
{
    public function __construct(
        private UserService $userService,
        private FormalityService $formalityService
    ) {
    }
    public function index()
    {
        $documentTypes = $this->userService->getDocumentTypes();
        $clientTypes = $this->userService->getClientTypes();
        $userTitles = $this->userService->getUserTitles();
        $formalitytypes = $this->formalityService->getFormalityTypes();
        $services = $this->formalityService->getServices();
        return view('admin.formality.create', compact(['formalitytypes', 'services', 'documentTypes', 'clientTypes', 'userTitles']));
    }
}
