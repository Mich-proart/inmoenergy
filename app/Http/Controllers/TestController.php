<?php

namespace App\Http\Controllers;

use App\Domain\Address\Services\AddressService;
use App\Domain\Program\Services\ComponentService;
use App\Domain\User\Services\UserService;
use App\Exceptions\CustomException;
use App\Http\Requests\Formality\CreateFormality;
use App\Http\Requests\TestRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function __construct(
        private readonly ComponentService $componentService,
    ) {
    }

    public function index()
    {
        return view('admin.email.fibraLineaTelefonica');
    }
}
