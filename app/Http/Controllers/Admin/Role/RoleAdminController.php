<?php

namespace App\Http\Controllers\Admin\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleAdminController extends Controller
{
    public function index()
    {
        $roles = Role::all('id', 'name')->sortBy('id');
        return view('admin.roles.index', compact('roles'));
    }

    public function show(string $id)
    {
        return view('admin.roles.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return view('admin.roles.edit', compact('role'));
    }

}
