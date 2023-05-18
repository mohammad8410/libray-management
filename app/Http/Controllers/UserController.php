<?php

namespace App\Http\Controllers;

use App\Actions\User\UserIndexAction;
use App\Http\Requests\UserIndexRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(UserIndexRequest $request, UserIndexAction $userIndexAction)
    {
        $this->authorize('index',User::class);

        return $userIndexAction->handle($request);
    }
}
