<?php

namespace App\Http\Controllers\Admin\Formality;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InProgressFormalityController extends Controller
{
    public function index()
    {
        return view('admin.formality.inprogress');
    }
}
