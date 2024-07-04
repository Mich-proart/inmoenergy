<?php

namespace App\Http\Controllers\Admin\Formality;

use App\Domain\Formality\Services\FormalityService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FormalityAdminController extends Controller
{

    public function __construct(
        private readonly FormalityService $formalityService
    ) {
    }
    public function create()
    {
        return view('admin.formality.create');
    }

    public function edit(int $id)
    {
        return view('admin.formality.edit', ['formalityId' => $id]);
    }
    public function get(int $id)
    {
        $formality = $this->formalityService->findByIdDetail($id);

        if ($formality)
            return view('admin.formality.get', ['formality' => $formality]);

    }
}
