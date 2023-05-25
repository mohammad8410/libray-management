<?php

namespace App\Actions\User;

use App\Http\Responses\UserResponse;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserIndexAction
{
    public function handle(User $user): JsonResponse
    {
        return new JsonResponse(new UserResponse($user));
    }
}
