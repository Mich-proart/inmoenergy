<?php

namespace App\Http\Controllers\Admin\Client;

use App\Http\Controllers\Controller;
use App\Models\Program;

class ClientRecordController extends Controller
{
    /**
     * Display the client record management screen
     */

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('can:client.record.access')->only('index');
    }

    public function index()
    {
        $program = Program::where('name', 'ver o editar fichas clientes')->first();
        return view('admin.client.client-record', ['program' => $program]);
    }
}
