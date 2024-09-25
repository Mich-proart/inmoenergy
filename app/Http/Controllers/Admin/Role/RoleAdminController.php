<?php

namespace App\Http\Controllers\Admin\Role;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleAdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:manage.role.access');
    }

    public function index()
    {
        $program = Program::where('name', 'gestión de roles')->first();
        return view('admin.roles.index', ['program' => $program]);
    }

    public function show(string $id)
    {
        return view('admin.roles.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $program = Program::where('name', 'gestión de roles')->first();
        $role = Role::find($id);
        if (!$role) {
            return view('admin.error.notFound');
        }

        return view('admin.roles.edit', ['role' => $role, 'program' => $program]);
    }

}
