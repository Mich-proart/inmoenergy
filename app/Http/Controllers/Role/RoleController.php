<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\RolesEnum;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    function __construct()
    {
        //$this->middleware('role:' . RolesEnum::SUPERADMIN->value);
    }

    public function index()
    {
        $roles = Role::all('id', 'name');

        if ($roles->isEmpty()) {
            return response()->json([
                'message' => 'No roles found'
            ], 404);
        }

        return response()->json($roles, 200);
    }
}
