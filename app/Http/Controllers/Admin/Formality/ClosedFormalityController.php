<?php

namespace App\Http\Controllers\Admin\Formality;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClosedFormalityController extends Controller
{
    public function index()
    {
        return view('admin.formality.closed');
    }
}
