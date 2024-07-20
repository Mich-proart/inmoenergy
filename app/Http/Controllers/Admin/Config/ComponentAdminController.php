<?php

namespace App\Http\Controllers\Admin\Config;

use App\Domain\Program\Services\ComponentService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ComponentAdminController extends Controller
{

    public function __construct(
        private readonly ComponentService $componentService
    ) {
    }

    public function details(int $id)
    {

        $component = $this->componentService->getById($id);
        if ($component)
            return view('admin.config.componentDetails', ['component' => $component]);
    }
    public function buinessDetails(int $id)
    {

        $business = $this->componentService->getBusinessById($id);
        if ($business)
            return view('admin.config.office', ['business' => $business]);
    }
}
