<?php

namespace App\Http\Controllers\User;

use App\Domain\User\Services\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserConntroller extends Controller
{
    public function __construct(
        private UserService $userService,
    ) {
    }

    public function index(Request $request)
    {
        $isClient = $request->query('isClient');
        $users = null;

        if ($isClient && $isClient == 'true') {
            $users = $this->userService->getClientUsers(true);
        } else {

            $users = $this->userService->getClientUsers(false);
        }


        return datatables()->of($users)
            ->setRowAttr(['align' => 'center'])
            ->setRowId(function ($user) {
                return $user->id;
            })
            ->addColumn('fullName', function ($user) {
                return $user->name . ' ' . $user->first_last_name . ' ' . $user->second_last_name;
            })
            ->addColumn('fullAddress', function ($user) {
                return $user->province . ' ' . $user->location . ' ' . $user->street_type . ' ' . $user->street_name . ' ' . $user->street_number . ' ' . $user->block . ' ' . $user->block_staircase . ' ' . $user->floor . ' ' . $user->door;
            })
            ->toJson();

    }

    public function create(Request $request)
    {
        $content = $request->query('content');
        return view('admin.user.create', ['content' => $content]);
    }
}
