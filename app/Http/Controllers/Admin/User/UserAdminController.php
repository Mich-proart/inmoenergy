<?php

namespace App\Http\Controllers\Admin\User;

use App\Domain\User\Services\UserService;
use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;

class UserAdminController extends Controller
{

    public function __construct(private readonly UserService $userService)
    {
    }

    public function edit(int $id, Request $request)
    {

        $content = $request->query('content');

        $program = Program::where('name', 'gestión de usuarios')->first();
        $user = $this->userService->getById($id);

        if ($content && $content != 'worker') {
            $program = Program::where('name', 'gestión de clientes')->first();
        }

        if ($user) {
            return view('admin.user.edit', ['userId' => $id, 'user' => $user, 'content' => $content, 'program' => $program]);
        } else {
            return view('admin.error.notFound');
        }

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
