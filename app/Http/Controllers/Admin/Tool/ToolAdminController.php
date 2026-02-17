<?php

namespace App\Http\Controllers\Admin\Tool;

use App\Http\Controllers\Controller;
use App\Models\Program;

class ToolAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:tool.statistics.client.access')->only('getStatisticsClient');
        $this->middleware('can:tool.statistics.worker.access')->only('getStatisticsWorker');
        $this->middleware('can:tool.statistics.formality.access')->only('getStatisticsFormality');
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

    public function getStatisticsFormality()
    {
        $program = Program::where('name', 'análisis trámites')->first();
        return view('admin.tool.statisticsFormality', ['program' => $program]);
    }
}
