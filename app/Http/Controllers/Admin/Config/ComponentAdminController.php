<?php

namespace App\Http\Controllers\Admin\Config;

use App\Domain\Program\Services\ComponentService;
use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Program;
use App\Models\Section;
use Illuminate\Http\Request;

class ComponentAdminController extends Controller
{

    public function __construct(
        private readonly ComponentService $componentService
    ) {
        $this->middleware('auth');
        $this->middleware('can:document.authorization.access')->only('docsAuth');
        $this->middleware('can:document.changeTitle.access')->only('docsChange');
        $this->middleware('can:config.dropdown.access')->only('index', 'details', 'buinessDetails', 'docsManager', 'getBusinnesGroup');
    }

    public function index()
    {
        $program = Program::where('name', 'desplegables')->first();
        return view('admin.config.component', ['program' => $program]);
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

    public function donwload(int $id)
    {
        $file = File::find($id);
        $path = storage_path('app/public/' . $file->folder . '/' . $file->filename);
        return response()->download($path);
    }
    public function docsManager()
    {
        $section = Section::where('name', 'documentación')->with('programs', 'programs.files')->first();
        return view('admin.config.documents', ['programs' => $section->programs]);

    }

    public function docsAuth()
    {
        $program = Program::where('name', 'autorización')->with('files')->first();
        return view('admin.document.authorization', ['program' => $program]);
    }
    public function docsChange()
    {
        $program = Program::where('name', 'documentos para cambio de titular')->with('files')->first();
        return view('admin.document.changeTitle', ['program' => $program]);
    }

    public function getBusinnesGroup()
    {
        return view('admin.config.businessGroup');
    }
}
