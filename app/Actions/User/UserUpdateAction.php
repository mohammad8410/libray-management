<?php

namespace App\Actions\User;

use App\Http\Responses\UserResponse;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserUpdateAction
{
    public function handle(User $user)
    {
        return new JsonResponse(new UserResponse($user));
    }

}
