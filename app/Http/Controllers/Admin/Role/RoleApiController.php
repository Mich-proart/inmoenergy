<?php

namespace App\Http\Controllers\Admin\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleApiController extends Controller
{
    public function __construct(

    ) {
        $this->middleware('auth');
    }

    public function getRoles()
    {
        $roles = Role::all();
        return DataTables::of($roles)
            ->setRowAttr(['align' => 'center'])
            ->setRowId(function ($roles) {
                return $roles->id;
            })
            ->toJson(true);
    }
}
