<?php

namespace App\Http\Controllers;

use App\Actions\User\UserDeleteAction;
use App\Actions\User\UserIndexAction;
use App\Actions\User\UserUpdateAction;
use App\Http\Requests\UserIndexRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(UserIndexRequest $request, UserIndexAction $userIndexAction)
    {
        $userId = Auth::user()->can('view any user')? $request->get('id') : Auth::user()->id;

        return $userIndexAction->handle($userId);
    }

    public function update(UserUpdateRequest $request, UserUpdateAction $userUpdateAction)
    {
        $this->authorize('update', User::class);

        return $userUpdateAction->handle($request);
    }

    public function delete(UserDeleteAction $userDeleteAction)
    {
        $this->authorize('delete', User::class);

        return $userDeleteAction->handle();
    }
}
