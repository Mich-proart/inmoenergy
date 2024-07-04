<?php

namespace App\Http\Controllers\Admin\Formality;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FormalityAdminController extends Controller
{
    public function create()
    {
        return view('admin.formality.create');
    }

    public function edit(int $id)
    {
        return view('admin.formality.edit', ['formalityId' => $id]);
    }
}
