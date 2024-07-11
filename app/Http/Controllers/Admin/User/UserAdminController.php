<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserAdminController extends Controller
{
    public function edit(int $id)
    {
        return view('admin.user.edit', ['userId' => $id]);
    }

}
