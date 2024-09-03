<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;

class UserAdminController extends Controller
{
    public function edit(int $id, Request $request)
    {

        $content = $request->query('content');

        $program = Program::where('name', 'gestión de usuarios')->first();

        if ($content && $content != 'worker') {
            $program = Program::where('name', 'gestión de clientes')->first();
        }

        return view('admin.user.edit', ['userId' => $id, 'content' => $content, 'program' => $program]);
    }


    public function getManageUsers()
    {
        $program = Program::where('name', 'gestión de usuarios')->first();
        return view('admin.user.users', ['program' => $program]);
    }

    public function getManageClients()
    {
        $program = Program::where('name', 'gestión de clientes')->first();
        return view('admin.user.clients', ['program' => $program]);
    }

    public function create(Request $request)
    {
        $content = $request->query('content');

        $program = Program::where('name', 'gestión de usuarios')->first();

        if ($content && $content != 'worker') {
            $program = Program::where('name', 'gestión de clientes')->first();
        }

        return view('admin.user.create', ['content' => $content, 'program' => $program]);
    }

}
