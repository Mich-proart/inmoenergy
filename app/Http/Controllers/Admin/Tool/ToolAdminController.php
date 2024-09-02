<?php

namespace App\Http\Controllers\Admin\Tool;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;

class ToolAdminController extends Controller
{
    public function getStatisticsClient()
    {
        $program = Program::where('name', 'estadísticas por cliente')->first();
        return view('admin.tool.statisticsClient', ['program' => $program]);
    }
    public function getStatisticsWorker()
    {
        $program = Program::where('name', 'estadísticas por trabajador')->first();
        return view('admin.tool.statisticsWorker', ['program' => $program]);
    }
}
