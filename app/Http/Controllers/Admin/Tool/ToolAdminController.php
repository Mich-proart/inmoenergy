<?php

namespace App\Http\Controllers\Admin\Tool;

use App\Http\Controllers\Controller;
use App\Models\Program;

class ToolAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getStatisticsClient()
    {
        $program = Program::where('name', 'análisis clientes')->first();
        return view('admin.tool.statisticsClient', ['program' => $program]);
    }

    public function getStatisticsWorker()
    {
        $program = Program::where('name', 'análisis usuarios')->first();
        return view('admin.tool.statisticsWorker', ['program' => $program]);
    }
}
