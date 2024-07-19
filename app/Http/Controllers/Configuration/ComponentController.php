<?php

namespace App\Http\Controllers\Configuration;


use App\Domain\Program\Services\ComponentService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ComponentController extends Controller
{
    public function __construct(
        private readonly ComponentService $componentService,
    ) {
    }

    public function index()
    {
        $components = $this->componentService->getAll();
        return datatables()->of($components)
            ->setRowAttr(['align' => 'center'])
            ->setRowId(function ($component) {
                return $component->id;
            })
            ->toJson();
    }

    public function options(Request $request)
    {

        $componentId = $request->query('componentId');

        if ($componentId) {
            $options = $this->componentService->getOptionsByComponentBy($componentId);
            return datatables()->of($options)
                ->setRowAttr(['align' => 'center'])
                ->setRowId(function ($option) {
                    return $option->id;
                })
                ->toJson();
        }

    }
}
