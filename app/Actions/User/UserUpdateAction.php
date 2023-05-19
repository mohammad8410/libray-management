<?php

namespace App\Actions\User;

use App\Http\Requests\UserUpdateRequest;
use App\Http\Responses\UserResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserUpdateAction
{
    public function handle(UserUpdateRequest $request)
    {
        $user = Auth::user();
        $user->update([
            'name' => $request->get('name'),
        ]);

        return new JsonResponse(new UserResponse($user));
    }

}
